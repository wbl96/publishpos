@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <!-- بطاقة المبيعات -->
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">إجمالي المبيعات</h6>
                            <h3 class="mb-0">{{ number_format($totalSales, 2) }} ريال</h3>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            عدد المبيعات: {{ $salesCount }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقة المصروفات -->
        <div class="col-md-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">إجمالي المصروفات</h6>
                            <h3 class="mb-0">{{ number_format($totalExpenses, 2) }} ريال</h3>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            عدد المصروفات: {{ $expensesCount }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- بطاقة صافي الربح -->
        <div class="col-md-4">
            <div class="card {{ $netProfit >= 0 ? 'bg-success' : 'bg-danger' }} text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50">صافي الربح</h6>
                            <h3 class="mb-0">{{ number_format($netProfit, 2) }} ريال</h3>
                        </div>
                        <div class="text-white-50">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-white-50">
                            نسبة الربح: {{ number_format($profitPercentage, 1) }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- رسم بياني للمبيعات والمصروفات -->
    <div class="card">
        <div class="card-body">
            <canvas id="salesExpensesChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('salesExpensesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'المبيعات',
                data: @json($chartSales),
                borderColor: 'rgb(54, 162, 235)',
                tension: 0.1
            }, {
                label: 'المصروفات',
                data: @json($chartExpenses),
                borderColor: 'rgb(255, 99, 132)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'المبيعات والمصروفات خلال الشهر'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
@endpush
@endsection 