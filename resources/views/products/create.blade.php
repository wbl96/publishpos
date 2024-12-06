@extends('layouts.app')

@section('header')
    <h2 class="fw-bold fs-4 text-dark">
        إضافة منتج جديد
    </h2>
@endsection

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">إضافة منتج جديد</h4>
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

            <form action="{{ route('products.store') }}" method="POST" id="productForm">
                @csrf
                
                <!-- اسم المنتج -->
                <div class="mb-3">
                    <label class="form-label">اسم المنتج</label>
                    <input type="text" 
                           name="name" 
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

                <!-- المكونات -->
                <div class="mb-3">
                    <label class="form-label">المكونات</label>
                    <div id="ingredientsList">
                        <!-- سيتم إضافة المكونات هنا -->
                    </div>
                    <button type="button" 
                            onclick="addNewIngredient()"
                            class="btn btn-primary mt-2">
                        <i class="fas fa-plus-circle me-2"></i>
                        إضافة مكون
                    </button>
                </div>

                <!-- سعر البيع -->
                <div class="mb-3">
                    <label class="form-label">سعر البيع</label>
                    <div class="input-group">
                        <input type="number" 
                               name="selling_price" 
                               class="form-control"
                               step="0.01"
                               value="{{ old('selling_price') }}"
                               onchange="calculateTotal()"
                               required>
                        <span class="input-group-text">ريال</span>
                    </div>
                </div>

                <!-- ملخص التكاليف -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">إجمالي التكلفة:</label>
                                <div id="totalCost" class="fs-5 fw-bold">0.00 ريال</div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">الربح المتوقع:</label>
                                <div id="expectedProfit" class="fs-5 fw-bold text-success">0.00 ريال</div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="ingredientsTotalCost" id="ingredientsTotalCost" value="0">

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>
                        حفظ المنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // تنفيذ الكود عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        addNewIngredient();
    });

    function addNewIngredient() {
        var list = document.getElementById('ingredientsList');
        var count = list.getElementsByClassName('ingredient-item').length;
        
        var newRow = `
            <div class="ingredient-item mb-3">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <input type="text" 
                               name="ingredients[${count}][name]" 
                               placeholder="اسم المكون"
                               class="form-control"
                               required>
                    </div>
                    <div class="col-2">
                        <div class="input-group">
                            <input type="number" 
                                   name="ingredients[${count}][cost]" 
                                   placeholder="التكلفة"
                                   class="form-control cost-input"
                                   step="0.01"
                                   onchange="calculateTotal()"
                                   required>
                            <span class="input-group-text">ريال</span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="button" 
                                onclick="removeIngredient(this)"
                                class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        list.insertAdjacentHTML('beforeend', newRow);
        calculateTotal();
    }

    function removeIngredient(button) {
        var list = document.getElementById('ingredientsList');
        if (list.getElementsByClassName('ingredient-item').length > 1) {
            button.closest('.ingredient-item').remove();
            calculateTotal();
        } else {
            alert('يجب إبقاء مكون واحد على الأقل');
        }
    }

    function calculateTotal() {
        var total = 0;
        document.querySelectorAll('.cost-input').forEach(function(input) {
            total += parseFloat(input.value) || 0;
        });
        
        var sellingPrice = parseFloat(document.querySelector('input[name="selling_price"]').value) || 0;
        var profit = sellingPrice - total;
        
        document.getElementById('totalCost').textContent = total.toFixed(2) + ' ريال';
        document.getElementById('expectedProfit').textContent = profit.toFixed(2) + ' ريال';
        document.getElementById('ingredientsTotalCost').value = total;
        
        var profitElement = document.getElementById('expectedProfit');
        profitElement.className = profit >= 0 ? 
            'fs-5 fw-bold text-success' : 
            'fs-5 fw-bold text-danger';
    }
</script>
@endsection
