<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تعديل المصروف
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('expenses.update', $expense) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">الفئة</label>
                                <select name="category" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        required>
                                    <option value="">اختر الفئة</option>
                                    <option value="رواتب" {{ $expense->category == 'رواتب' ? 'selected' : '' }}>رواتب</option>
                                    <option value="إيجار" {{ $expense->category == 'إيجار' ? 'selected' : '' }}>إيجار</option>
                                    <option value="كهرباء" {{ $expense->category == 'كهرباء' ? 'selected' : '' }}>كهرباء</option>
                                    <option value="ماء" {{ $expense->category == 'ماء' ? 'selected' : '' }}>ماء</option>
                                    <option value="صيانة" {{ $expense->category == 'صيانة' ? 'selected' : '' }}>صيانة</option>
                                    <option value="أخرى" {{ $expense->category == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">المبلغ</label>
                                <input type="number" 
                                       name="amount" 
                                       value="{{ $expense->amount }}"
                                       step="0.01"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">التاريخ</label>
                                <input type="date" 
                                       name="expense_date" 
                                       value="{{ $expense->expense_date->format('Y-m-d') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                       required>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">الوصف</label>
                                <textarea name="description" 
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ $expense->description }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                تحديث المصروف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 