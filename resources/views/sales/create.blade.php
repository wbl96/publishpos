@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">إضافة عملية بيع جديدة</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                
                <!-- المنتج -->
                <div class="mb-3">
                    <label class="form-label">المنتج</label>
                    <select name="product_id" 
                            id="product_id" 
                            class="form-select"
                            onchange="updateProductDetails()"
                            required>
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-price="{{ $product->selling_price }}"
                                    data-cost="{{ $product->production_cost }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- الكمية -->
                <div class="mb-3">
                    <label class="form-label">الكمية</label>
                    <input type="number" 
                           name="quantity" 
                           id="quantity"
                           class="form-control"
                           min="1"
                           value="1"
                           onchange="calculateTotal()"
                           required>
                </div>

                <!-- سعر الوحدة -->
                <div class="mb-3">
                    <label class="form-label">سعر الوحدة</label>
                    <div class="input-group">
                        <input type="number" 
                               id="unit_price"
                               name="unit_price" 
                               class="form-control"
                               step="0.01"
                               readonly
                               required>
                        <span class="input-group-text">ريال</span>
                    </div>
                </div>

                <!-- تكلفة الوحدة -->
                <div class="mb-3">
                    <label class="form-label">تكلفة الوحدة</label>
                    <div class="input-group">
                        <input type="number" 
                               id="unit_cost"
                               class="form-control"
                               step="0.01"
                               readonly>
                        <span class="input-group-text">ريال</span>
                    </div>
                </div>

                <!-- إجمالي المبلغ -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">إجمالي المبلغ:</label>
                                <div id="total_amount" class="fs-4 fw-bold text-success">0.00 ريال</div>
                                <input type="hidden" name="total_amount" id="total_amount_input" value="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">إجمالي الربح:</label>
                                <div id="total_profit" class="fs-4 fw-bold text-primary">0.00 ريال</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>
                        حفظ عملية البيع
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateProductDetails() {
    const select = document.getElementById('product_id');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        document.getElementById('unit_price').value = selectedOption.dataset.price;
        document.getElementById('unit_cost').value = selectedOption.dataset.cost;
    } else {
        document.getElementById('unit_price').value = '';
        document.getElementById('unit_cost').value = '';
    }
    
    calculateTotal();
}

function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
    const unitCost = parseFloat(document.getElementById('unit_cost').value) || 0;
    
    const totalAmount = quantity * unitPrice;
    const totalCost = quantity * unitCost;
    const totalProfit = totalAmount - totalCost;
    
    document.getElementById('total_amount').textContent = totalAmount.toFixed(2) + ' ريال';
    document.getElementById('total_amount_input').value = totalAmount.toFixed(2);
    document.getElementById('total_profit').textContent = totalProfit.toFixed(2) + ' ريال';
    
    // تغيير لون الربح حسب القيمة
    const profitElement = document.getElementById('total_profit');
    profitElement.className = totalProfit >= 0 ? 
        'fs-4 fw-bold text-success' : 
        'fs-4 fw-bold text-danger';
}

// تحديث القيم عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    updateProductDetails();
});
</script>
@endsection 