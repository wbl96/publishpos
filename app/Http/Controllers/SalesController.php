<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with('product')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();
        
        $products = Product::where('user_id', auth()->id())->get();
        
        return view('sales.index', compact('sales', 'products'));
    }

    public function create()
    {
        $products = Product::whereHas('inventory', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'sale_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $inventory = $product->inventory()->where('user_id', auth()->id())->first();
        if (!$inventory || $inventory->stock_quantity < $request->quantity) {
            return redirect()->back()->with('error', 'الكمية المطلوبة غير متوفرة في المخزون');
        }

        $inventory->decrement('stock_quantity', $request->quantity);

        Sale::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'unit_price' => $product->selling_price,
            'total_amount' => $product->selling_price * $request->quantity,
            'total_cost' => $product->production_cost * $request->quantity,
            'profit' => ($product->selling_price * $request->quantity) - ($product->production_cost * $request->quantity),
            'sale_date' => $request->sale_date,
        ]);

        return redirect()->route('sales.index')
                        ->with('success', 'تم إضافة المبيعات بنجاح وتحديث المخزون');
    }

    public function edit(Sale $sale)
    {
        $products = Product::whereHas('inventory', function($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('sales.edit', compact('sale', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'sale_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $sale->update([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'unit_price' => $product->selling_price,
            'total_amount' => $product->selling_price * $request->quantity,
            'total_cost' => $product->production_cost * $request->quantity,
            'profit' => ($product->selling_price * $request->quantity) - ($product->production_cost * $request->quantity),
            'sale_date' => $request->sale_date,
        ]);

        return redirect()->route('sales.index')
                        ->with('success', 'تم تحديث المبيعات بنجاح');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')
                        ->with('success', 'تم حذف المبيعات بنجاح');
    }
} 