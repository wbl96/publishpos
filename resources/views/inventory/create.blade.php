@extends('layouts.app')

@section('header')
    <h2 class="fw-bold fs-4 text-dark">
        إضافة مخزون جديد
    </h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('inventory.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label fw-bold">المنتج</label>
                    <select name="product_id" class="form-select" required>
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" 
                                    data-cost="{{ $product->production_cost }}">
                                {{ $product->name }} 
                                (تكلفة الوحدة: {{ number_format($product->production_cost, 2) }} ريال)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">الكمية</label>
                    <input type="number" 
                           name="quantity" 
                           class="form-control"
                           min="1"
                           required
                           onchange="calculateTotalCost()">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">التاريخ</label>
                    <input type="date" 
                           name="date" 
                           class="form-control"
                           required
                           value="{{ date('Y-m-d') }}">
                </div>

                <div class="mb-3 bg-light p-3 rounded">
                    <label class="form-label fw-bold">إجمالي التكلفة:</label>
                    <div id="totalCost" class="fs-5 fw-bold">0.00 ريال</div>
                    <small class="text-muted">
                        * سيتم تسجيل هذا المبلغ تلقائياً في المصروفات
                    </small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function calculateTotalCost() {
    const select = document.querySelector('select[name="product_id"]');
    const quantity = document.querySelector('input[name="quantity"]').value || 0;
    const cost = select.options[select.selectedIndex].dataset.cost || 0;
    
    const total = parseFloat(cost) * parseFloat(quantity);
    document.getElementById('totalCost').textContent = total.toFixed(2) + ' ريال';
}

document.querySelector('select[name="product_id"]').addEventListener('change', calculateTotalCost);
</script>
@endpush 