<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Sale;
use App\Models\Product;
use Livewire\WithPagination;

class Sales extends Component
{
    use WithPagination;

    public $product_id;
    public $quantity = 1;
    public $sale_date;
    public $selectedProduct = null;
    
    // للحسابات التلقائية
    public $unit_price = 0;
    public $total_amount = 0;
    public $total_cost = 0;
    public $profit = 0;

    public function mount()
    {
        $this->sale_date = date('Y-m-d');
    }

    public function updatedProductId($value)
    {
        if ($value) {
            $this->selectedProduct = Product::find($value);
            $this->calculateTotals();
        }
    }

    public function updatedQuantity()
    {
        $this->calculateTotals();
    }

    private function calculateTotals()
    {
        if ($this->selectedProduct && $this->quantity > 0) {
            $this->unit_price = $this->selectedProduct->selling_price;
            $this->total_amount = $this->unit_price * $this->quantity;
            $this->total_cost = $this->selectedProduct->production_cost * $this->quantity;
            $this->profit = $this->total_amount - $this->total_cost;
        }
    }

    public function saveSale()
    {
        $this->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'sale_date' => 'required|date',
        ]);

        Sale::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'unit_price' => $this->unit_price,
            'total_amount' => $this->total_amount,
            'total_cost' => $this->total_cost,
            'profit' => $this->profit,
            'sale_date' => $this->sale_date,
        ]);

        $this->reset(['product_id', 'quantity']);
        $this->sale_date = date('Y-m-d');
        
        session()->flash('message', 'تم حفظ المبيعات بنجاح');
    }

    public function render()
    {
        $sales = Sale::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return view('livewire.user.sales', [
            'sales' => $sales
        ]);
    }
}
