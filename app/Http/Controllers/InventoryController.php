<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::with(['inventory' => function($query) {
            $query->where('user_id', auth()->id());
        }])->where('user_id', auth()->id())->get();

        $totalInventoryValue = $products->sum(function($product) {
            return ($product->inventory->stock_quantity ?? 0) * $product->production_cost;
        });

        $lowStockProducts = $products->filter(function($product) {
            return ($product->inventory->stock_quantity ?? 0) <= ($product->inventory->min_stock ?? 0);
        });

        return view('inventory.index', compact('products', 'totalInventoryValue', 'lowStockProducts'));
    }

    public function updateStock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'action' => 'required|in:add,subtract',
            'quantity' => 'required|integer|min:1',
            'min_stock' => 'nullable|integer|min:0'
        ]);

        DB::beginTransaction();
        
        try {
            $inventory = Inventory::firstOrNew(['product_id' => $product->id]);
            
            if (!$inventory->exists) {
                $inventory->user_id = auth()->id();
                $inventory->stock_quantity = 0;
                $inventory->min_stock = $validated['min_stock'] ?? 0;
            }

            switch($validated['action']) {
                case 'add':
                    $inventory->stock_quantity += $validated['quantity'];
                    
                    // إنشاء مصروف عند الإضافة
                    $totalCost = $product->production_cost * $validated['quantity'];
                    Expense::create([
                        'user_id' => auth()->id(),
                        'category' => 'تكاليف إنتاج',
                        'amount' => $totalCost,
                        'description' => "تكاليف إنتاج {$validated['quantity']} وحدة من {$product->name}",
                        'expense_date' => now()
                    ]);
                    
                    $message = "تم إضافة {$validated['quantity']} وحدة للمخزون وتسجيل المصروفات";
                    break;

                case 'subtract':
                    if($inventory->stock_quantity < $validated['quantity']) {
                        throw new \Exception('الكمية المطلوب خصمها أكبر من المخزون المتوفر');
                    }
                    $inventory->stock_quantity -= $validated['quantity'];
                    $message = "تم خصم {$validated['quantity']} وحدة من المخزون";
                    break;
            }

            if (isset($validated['min_stock'])) {
                $inventory->min_stock = $validated['min_stock'];
            }

            $inventory->save();
            
            DB::commit();
            return redirect()->route('inventory.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // دالة لتحديث المخزون عند البيع
    public function decreaseStock($product_id, $quantity)
    {
        $inventory = Inventory::where('product_id', $product_id)->first();
        
        if (!$inventory || $inventory->stock_quantity < $quantity) {
            throw new \Exception('الكمية المطلوبة غير متوفرة في المخزون');
        }

        $inventory->decrement('stock_quantity', $quantity);
        
        // إذا وصل المخزون للحد الأدنى
        if ($inventory->stock_quantity <= $inventory->min_stock) {
            // يمكنك إضافة إشعار هنا
            \Log::warning("المخزون وصل للحد الأدنى: {$inventory->product->name}");
        }

        return true;
    }

    public function addStock(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'min_stock' => 'nullable|integer|min:0'
            ]);

            $product = Product::findOrFail($validated['product_id']);
            $totalCost = $product->production_cost * $validated['quantity'];

            DB::beginTransaction();

            try {
                $inventory = Inventory::firstOrNew([
                    'product_id' => $product->id,
                    'user_id' => auth()->id()
                ]);
                
                if (!$inventory->exists) {
                    $inventory->stock_quantity = 0;
                }

                $inventory->stock_quantity += $validated['quantity'];
                $inventory->unit_cost = $product->production_cost;
                $inventory->min_stock = $validated['min_stock'] ?? $inventory->min_stock ?? 0;
                $inventory->save();

                Expense::create([
                    'user_id' => auth()->id(),
                    'category' => 'تكاليف إنتاج',
                    'amount' => $totalCost,
                    'description' => sprintf(
                        "تكاليف إنتاج %d وحدة من %s", 
                        $validated['quantity'], 
                        $product->name
                    ),
                    'expense_date' => now()
                ]);

                DB::commit();

                return redirect()->back()->with('success', 
                    sprintf(
                        "تم إضافة %d وحدة للمخزون (الإجمالي: %d) وتسجيل المصروفات بقيمة %s ريال",
                        $validated['quantity'],
                        $inventory->stock_quantity,
                        number_format($totalCost, 2)
                    )
                );

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            \Log::error('خطأ في إضافة المخزون:', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return back()
                ->withInput()
                ->with('error', 'حدث خطأ أثناء تحديث المخزون: ' . $e->getMessage());
        }
    }
} 