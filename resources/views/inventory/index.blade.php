@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>المخزون</h4>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStock">
                <i class="fas fa-plus-circle me-2"></i>إضافة مخزون
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th>الكمية المتوفرة</th>
                            <th>الحد الأدنى</th>
                            <th>تكلفة الوحدة</th>
                            <th>قيمة المخزون</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            @php
                                $inventory = $product->inventory;
                                $stockQuantity = $inventory ? $inventory->stock_quantity : 0;
                                $minStock = $inventory ? $inventory->min_stock : 0;
                                $unitCost = $inventory ? $inventory->unit_cost : $product->production_cost;
                                $totalValue = $stockQuantity * $unitCost;
                            @endphp
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $stockQuantity }}</td>
                                <td>{{ $minStock }}</td>
                                <td>{{ number_format($unitCost, 2) }} ريال</td>
                                <td>{{ number_format($totalValue, 2) }} ريال</td>
                                <td>
                                    @if($stockQuantity <= $minStock)
                                        <span class="badge bg-danger">تحت الحد الأدنى</span>
                                    @else
                                        <span class="badge bg-success">متوفر</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-primary" 
                                            onclick="editStock({{ $product->id }}, '{{ $product->name }}', {{ $stockQuantity }}, {{ $minStock }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">لا يوجد منتجات في المخزون</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة مخزون -->
<div class="modal fade" id="addStock" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة مخزون</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('inventory.add-stock') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">المنتج</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">اختر المنتج</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                        data-cost="{{ $product->production_cost }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الكمية</label>
                        <input type="number" name="quantity" class="form-control" required min="1">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الحد الأدنى</label>
                        <input type="number" name="min_stock" class="form-control" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">تكلفة الوحدة</label>
                        <input type="text" id="unit_cost" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">التكلفة الإجمالية</label>
                        <input type="text" id="total_cost" class="form-control" readonly>
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
document.querySelector('select[name="product_id"]').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const cost = option.dataset.cost || 0;
    document.getElementById('unit_cost').value = parseFloat(cost).toFixed(2) + ' ريال';
    calculateTotal();
});

document.querySelector('input[name="quantity"]').addEventListener('input', calculateTotal);

function calculateTotal() {
    const select = document.querySelector('select[name="product_id"]');
    const option = select.options[select.selectedIndex];
    const quantity = document.querySelector('input[name="quantity"]').value || 0;
    const cost = option.dataset.cost || 0;
    
    const total = parseFloat(cost) * parseFloat(quantity);
    document.getElementById('total_cost').value = total.toFixed(2) + ' ريال';
}

function editStock(productId, productName, currentStock, minStock) {
    // يمكنك إضافة منطق تحرير المخزون هنا
}

// تنظيف النموذج عند إغلاق النافذة المنبثقة
document.getElementById('addStock').addEventListener('hidden.bs.modal', function () {
    this.querySelector('form').reset();
    document.getElementById('unit_cost').value = '';
    document.getElementById('total_cost').value = '';
});
</script>
@endpush
@endsection 