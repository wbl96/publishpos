<div class="p-6">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">إضافة مبيعات جديدة</h3>
        
        @if (session()->has('message'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="saveSale">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- اختيار المنتج -->
                <div>
                    <label class="block mb-1">المنتج</label>
                    <select wire:model="product_id" class="w-full rounded border p-2">
                        <option value="">اختر المنتج</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- الكمية -->
                <div>
                    <label class="block mb-1">الكمية</label>
                    <input type="number" wire:model="quantity" class="w-full rounded border p-2" min="1">
                    @error('quantity') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- التاريخ -->
                <div>
                    <label class="block mb-1">التاريخ</label>
                    <input type="date" wire:model="sale_date" class="w-full rounded border p-2">
                    @error('sale_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- تفاصيل الحساب -->
            @if($selectedProduct)
            <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded">
                <div>
                    <label class="block mb-1 font-semibold">سعر البيع</label>
                    <span class="block">{{ number_format($unit_price, 2) }} ريال</span>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">المبلغ الإجمالي</label>
                    <span class="block">{{ number_format($total_amount, 2) }} ريال</span>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">الربح المتوقع</label>
                    <span class="block {{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($profit, 2) }} ريال
                    </span>
                </div>
            </div>
            @endif

            <div class="mt-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    حفظ المبيعات
                </button>
            </div>
        </form>
    </div>

    <!-- جدول المبيعات -->
    <div class="bg-white rounded-lg shadow">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-right">المنتج</th>
                    <th class="p-4 text-right">الكمية</th>
                    <th class="p-4 text-right">السعر</th>
                    <th class="p-4 text-right">الإجمالي</th>
                    <th class="p-4 text-right">الربح</th>
                    <th class="p-4 text-right">التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr class="border-t">
                        <td class="p-4">{{ $sale->product->name }}</td>
                        <td class="p-4">{{ $sale->quantity }}</td>
                        <td class="p-4">{{ number_format($sale->unit_price, 2) }} ريال</td>
                        <td class="p-4">{{ number_format($sale->total_amount, 2) }} ريال</td>
                        <td class="p-4">
                            <span class="{{ $sale->profit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($sale->profit, 2) }} ريال
                            </span>
                        </td>
                        <td class="p-4">{{ $sale->sale_date->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="p-4">
            {{ $sales->links() }}
        </div>
    </div>
</div>