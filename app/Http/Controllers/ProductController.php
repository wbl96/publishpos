<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', auth()->id())
            ->select([
                'id',
                'name',
                'selling_price',
                'production_cost',
                'profit',
                'ingredients'
            ])
            ->get()
            ->map(function ($product) {
                // التعامل مع المكونات بشكل آمن
                $ingredients = is_string($product->ingredients) 
                    ? json_decode($product->ingredients, true) 
                    : (is_array($product->ingredients) 
                        ? $product->ingredients 
                        : []);

                // تنسيق القيم النقدية
                $product->formatted_production_cost = number_format($product->production_cost, 2) . ' ريال';
                $product->formatted_selling_price = number_format($product->selling_price, 2) . ' ريال';
                $product->formatted_profit = number_format($product->profit, 2) . ' ريال';

                return $product;
            });

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        \Log::info('Form data:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
        ]);

        try {
            // الحصول على إجمالي التكلفة من الحقل المخفي
            $productionCost = floatval($request->input('ingredientsTotalCost', 0));
            
            \Log::info('Production Cost:', ['cost' => $productionCost]);

            // حساب الربح
            $profit = $validated['selling_price'] - $productionCost;

            $product = Product::create([
                'user_id' => auth()->id(),
                'name' => $validated['name'],
                'selling_price' => $validated['selling_price'],
                'production_cost' => $productionCost,
                'profit' => $profit,
                'ingredients' => json_encode($request->input('ingredients', [])),
            ]);

            \Log::info('Saved product:', $product->toArray());

            return redirect()->route('inventory.index')
                ->with('success', 'تم إضافة المنتج بنجاح');
        } catch (\Exception $e) {
            \Log::error('Error:', [
                'message' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return redirect()->back()
                ->withErrors(['error' => 'حدث خطأ أثناء حفظ المنتج: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('products.index')
                        ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function show(Product $product)
    {
        if ($product->user_id !== auth()->id()) {
            abort(403);
        }

        return view('products.show', compact('product'));
    }
}
