@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- محتوى لوحة التحكم -->
    <div class="content-wrapper" style="margin-top: 80px; padding: 20px;">
        <style>
            .dashboard-stats {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            .stat-card {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                transition: transform 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-5px);
            }

            .stat-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
            }

            .stat-title {
                color: #666;
                font-size: 1rem;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
            }

            .stat-icon.sales {
                background: #3498DB;
            }

            .stat-icon.expenses {
                background: #E74C3C;
            }

            .stat-icon.profit {
                background: #27AE60;
            }

            .stat-icon.products {
                background: #F39C12;
            }

            .stat-value {
                font-size: 1.8rem;
                font-weight: 600;
                color: #2C3E50;
                margin-bottom: 0.5rem;
            }

            .stat-change {
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                gap: 0.3rem;
            }

            .stat-change.positive {
                color: #27AE60;
            }

            .stat-change.negative {
                color: #E74C3C;
            }

            .chart-container {
                background: white;
                border-radius: 12px;
                padding: 1.5rem;
                box-shadow: 0 2px 10px rgba(0,0,0,0.05);
                margin-top: 2rem;
            }

            .chart-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1.5rem;
            }

            .chart-title {
                font-size: 1.2rem;
                font-weight: 600;
                color: #2C3E50;
            }

            .chart-filters {
                display: flex;
                gap: 1rem;
            }

            .chart-filter {
                padding: 0.5rem 1rem;
                border-radius: 6px;
                border: 1px solid #ddd;
                background: white;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .chart-filter:hover {
                background: #f8f9fa;
            }

            .chart-filter.active {
                background: #3498DB;
                color: white;
                border-color: #3498DB;
            }
        </style>

        <!-- إحصائيات سريعة -->
        <div class="dashboard-stats">
            <!-- بطاقة إجمالي المبيعات -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">إجمالي المبيعات</span>
                    <div class="stat-icon sales">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $data['totalSales'] }} ر.س</div>
                @if(isset($data['salesChange']))
                <div class="stat-change {{ $data['salesChange'] >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $data['salesChange'] >= 0 ? 'up' : 'down' }}"></i>
                    <span>{{ abs($data['salesChange']) }}% من الشهر الماضي</span>
                </div>
                @endif
            </div>

            <!-- بطاقة المصروفات -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">المصروفات</span>
                    <div class="stat-icon expenses">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $data['totalExpenses'] }} ر.س</div>
                @if(isset($data['expensesChange']))
                <div class="stat-change {{ $data['expensesChange'] >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $data['expensesChange'] >= 0 ? 'up' : 'down' }}"></i>
                    <span>{{ abs($data['expensesChange']) }}% من الشهر الماضي</span>
                </div>
                @endif
            </div>

            <!-- بطاقة صافي الربح -->
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">صافي الربح</span>
                    <div class="stat-icon profit">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $data['netProfit'] }} ر.س</div>
                @if(isset($data['profitChange']))
                <div class="stat-change {{ $data['profitChange'] >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas fa-arrow-{{ $data['profitChange'] >= 0 ? 'up' : 'down' }}"></i>
                    <span>{{ abs($data['profitChange']) }}% من الشهر الماضي</span>
                </div>
                @endif
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-title">المنتجات النشطة</span>
                    <div class="stat-icon products">
                        <i class="fas fa-box"></i>
                    </div>
                </div>
                <div class="stat-value">142</div>
                <div class="stat-change positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>5 منتجات جديدة</span>
                </div>
            </div>
        </div>

        <!-- الرسم البياني -->
        <div class="chart-container">
            <div class="chart-header">
                <h3 class="chart-title">تحليل المبيعات والمصروفات</h3>
                <div class="chart-filters">
                    <button class="chart-filter active">أسبوعي</button>
                    <button class="chart-filter">شهري</button>
                    <button class="chart-filter">سنوي</button>
                </div>
            </div>
            <div id="sales-chart" style="height: 300px;">
                <!-- هنا يتم إضافة الرسم البياني باستخد��م مكتبة مثل Chart.js -->
            </div>
        </div>

        @if(session('debug'))
        <div class="alert alert-info">
            <h5>معلومات التحقق:</h5>
            <ul>
                <li>إجمالي المبيعات (خام): {{ session('debug.raw_total_sales') }}</li>
                <li>عدد المبيعات: {{ session('debug.sales_count') }}</li>
                <li>إجمالي الكميات: {{ session('debug.total_quantity') }}</li>
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection
