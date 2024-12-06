<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <!-- Sales Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="mx-4">
                                    <h4 class="text-2xl font-semibold text-gray-700">0.00 ريال</h4>
                                    <div class="text-gray-500">المبيعات</div>
                                </div>
                            </div>
                        </div>

                        <!-- Expenses Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-100 text-red-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                </div>
                                <div class="mx-4">
                                    <h4 class="text-2xl font-semibold text-gray-700">0.00 ريال</h4>
                                    <div class="text-gray-500">المصروفات</div>
                                </div>
                            </div>
                        </div>

                        <!-- Profit Card -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <div class="mx-4">
                                    <h4 class="text-2xl font-semibold text-gray-700">0.00 ريال</h4>
                                    <div class="text-gray-500">الأرباح</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-xl font-semibold mb-4">تحليل المبيعات والمصروفات</h3>
                        <div class="h-64">
                            <!-- We'll add the chart here later -->
                            <div class="flex items-center justify-center h-full text-gray-500">
                                سيتم إضافة الرسم البياني قريباً
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="mt-6 bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-4">النشاطات الأخيرة</h3>
                            <div class="border-t">
                                <div class="p-4 text-gray-500 text-center">
                                    لا توجد نشاطات حديثة
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 