@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">المصروفات</h3>
                    <a href="{{ route('expenses.create') }}" class="btn btn-primary">
                        إضافة مصروف جديد
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>التصنيف</th>
                                    <th>المبلغ</th>
                                    <th>التاريخ</th>
                                    <th>الوصف</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expenses as $expense)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $expense->category }}</td>
                                        <td>{{ number_format($expense->amount, 2) }} ريال</td>
                                        <td>{{ $expense->expense_date->format('Y-m-d') }}</td>
                                        <td>{{ $expense->description ?? '-' }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('expenses.edit', $expense) }}" 
                                                   class="btn btn-sm btn-info">
                                                    تعديل
                                                </a>
                                                <form action="{{ route('expenses.destroy', $expense) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            لا توجد مصروفات حتى الآن
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $expenses->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 