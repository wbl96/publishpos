<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            إضافة مصروفات جديدة
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded relative">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- الفئة -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                    الفئة
                                </label>
                                <select id="category" 
                                        name="category" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category') border-red-500 @enderror"
                                        required>
                                    <option value="">اختر الفئة</option>
                                    <option value="رواتب" {{ old('category') == 'رواتب' ? 'selected' : '' }}>رواتب</option>
                                    <option value="إيجار" {{ old('category') == 'إيجار' ? 'selected' : '' }}>إيجار</option>
                                    <option value="كهرباء" {{ old('category') == 'كهرباء' ? 'selected' : '' }}>كهرباء</option>
                                    <option value="ماء" {{ old('category') == 'ماء' ? 'selected' : '' }}>ماء</option>
                                    <option value="صيانة" {{ old('category') == 'صيانة' ? 'selected' : '' }}>صيانة</option>
                                    <option value="أخرى" {{ old('category') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- المبلغ -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                                    المبلغ
                                </label>
                                <input type="number" 
                                       id="amount" 
                                       name="amount" 
                                       step="0.01"
                                       value="{{ old('amount') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('amount') border-red-500 @enderror"
                                       required>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- التاريخ -->
                            <div>
                                <label for="expense_date" class="block text-sm font-medium text-gray-700 mb-1">
                                    التاريخ
                                </label>
                                <input type="date" 
                                       id="expense_date" 
                                       name="expense_date"
                                       value="{{ old('expense_date', date('Y-m-d')) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('expense_date') border-red-500 @enderror"
                                       required>
                                @error('expense_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- الوصف -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    الوصف
                                </label>
                                <textarea id="description" 
                                          name="description" 
                                          rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3 space-x-reverse">
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                حفظ المصروف
                            </button>
                            <a href="{{ route('expenses.index') }}" 
                               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                إلغاء
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 