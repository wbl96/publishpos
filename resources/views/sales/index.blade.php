@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>المبيعات</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSale">
                <i class="fas fa-plus-circle me-2"></i>إضافة مبيعات جديدة
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية</th>
                            <th>سعر الوحدة</th>
                            <th>الإجمالي</th>
                            <th>الربح</th>
                            <th>تاريخ البيع</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                            <tr>
                                <td>{{ $sale->product->name }}</td>
                                <td>{{ $sale->quantity }}</td>
                                <td>{{ number_format($sale->unit_price, 2) }} ريال</td>
                                <td>{{ number_format($sale->total_amount, 2) }} ريال</td>
                                <td>{{ number_format($sale->profit, 2) }} ريال</td>
                                <td>{{ $sale->sale_date->format('Y-m-d') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="deleteSale({{ $sale->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا توجد مبيعات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة مبيعات -->
<div class="modal fade" id="addSale" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مبيعات جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">المنتج</label>
                                <select name="product_id" class="form-select" required onchange="updateProductDetails()">
                                    <option value="">اختر المنتج</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                                data-cost="{{ $product->production_cost }}"
                                                data-price="{{ $product->selling_price }}">
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">الكمية</label>
                                <input type="number" 
                                       name="quantity" 
                                       class="form-control" 
                                       required 
                                       min="1" 
                                       value="1"
                                       onchange="calculateTotals()">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">تكلفة الوحدة</label>
                                <input type="text" id="cost_per_unit" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">سعر البيع</label>
                                <input type="text" id="unit_price" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">إجمالي المبلغ</label>
                                <input type="text" id="total_amount" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">تاريخ البيع</label>
                                <input type="date" 
                                       name="sale_date" 
                                       class="form-control" 
                                       required 
                                       value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label">ملاحظات</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateProductDetails() {
    const select = document.querySelector('select[name="product_id"]');
    const option = select.options[select.selectedIndex];
    
    if (option.value) {
        document.getElementById('cost_per_unit').value = parseFloat(option.dataset.cost).toFixed(2) + ' ريال';
        document.getElementById('unit_price').value = parseFloat(option.dataset.price).toFixed(2) + ' ريال';
        calculateTotals();
    } else {
        document.getElementById('cost_per_unit').value = '';
        document.getElementById('unit_price').value = '';
        document.getElementById('total_amount').value = '';
    }
}

function calculateTotals() {
    const select = document.querySelector('select[name="product_id"]');
    const option = select.options[select.selectedIndex];
    const quantity = parseFloat(document.querySelector('input[name="quantity"]').value) || 0;
    
    if (option.value) {
        const price = parseFloat(option.dataset.price);
        const totalAmount = quantity * price;
        document.getElementById('total_amount').value = totalAmount.toFixed(2) + ' ريال';
    }
}

function deleteSale(saleId) {
    if (confirm('هل أنت متأكد من حذف هذا البيع؟')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/sales/${saleId}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// تنظيف النموذج عند إغلاق النافذة المنبثقة
document.getElementById('addSale').addEventListener('hidden.bs.modal', function () {
    this.querySelector('form').reset();
    document.getElementById('cost_per_unit').value = '';
    document.getElementById('unit_price').value = '';
    document.getElementById('total_amount').value = '';
});

// تشغيل الحسابات عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    updateProductDetails();
});
</script>
@endpush
@endsection 