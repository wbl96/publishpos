<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // حساب إجمالي المبيعات
            $totalSales = Sale::where('user_id', auth()->id())
                ->sum('total_amount') ?? 0;

            // حساب إجمالي المصروفات
            $totalExpenses = Expense::where('user_id', auth()->id())
                ->sum('amount') ?? 0;

            // حساب صافي الربح (المبيعات - المصروفات)
            $netProfit = $totalSales - $totalExpenses;

            // تجهيز البيانات للعرض
            $data = [
                'totalSales' => number_format($totalSales, 2),
                'totalExpenses' => number_format($totalExpenses, 2),
                'netProfit' => number_format($netProfit, 2),
                'rawNetProfit' => $netProfit
            ];

            return view('dashboard', compact('data'));
        } catch (\Exception $e) {
            \Log::error('Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'حدث خطأ أثناء تحميل لوحة التحكم');
        }
    }
} 