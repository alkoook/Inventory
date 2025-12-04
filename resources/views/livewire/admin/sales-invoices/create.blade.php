<div>
    <div class="max-w-4xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm p-6">

        <h2 class="text-xl font-bold text-gray-900 mb-6">إنشاء فاتورة مبيعات</h2>

        <form wire:submit.prevent="save" class="space-y-6">

            <!-- Customer + Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Customer -->
                <div wire:ignore>
                    <label class="block mb-2 text-sm font-medium text-gray-700">الزبون *</label>

                    <select 
                        class="customer-select w-full bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-blue-500"
                        wire:model="customer_id"
                    >
                        <option value="">اختر...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('customer_id')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">التاريخ *</label>
                    <input 
                        wire:model="invoice_date" 
                        type="date" 
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-blue-500"
                    >
                    @error('invoice_date')
                        <span class="text-red-600 text-xs">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <!-- Items -->
            <div class="border rounded-xl p-4 bg-gray-50/60">

                <h3 class="font-semibold mb-3 text-gray-800">الأصناف</h3>

                @foreach($items as $index => $item)

                <div class="flex flex-col md:flex-row items-start gap-3 mb-4">

                    <!-- Product Selector -->
                    <div class="flex-1" wire:ignore>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">المنتج *</label>

                        <select 
                            class="product-select w-full bg-white border border-gray-300 rounded-xl p-2.5 focus:ring-blue-500"
                            data-index="{{ $index }}"
                        >
                            <option value="">اختر منتج...</option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (المتوفر: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>

                        @error("items.$index.product_id")
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">الكمية *</label>
                        <input 
                            wire:model="items.{{ $index }}.quantity"
                            type="number" min="1"
                            class="w-28 bg-white border border-gray-300 rounded-xl p-2.5 text-center focus:ring-blue-500"
                            placeholder="الكمية"
                        >
                        @error("items.$index.quantity")
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Unit Price -->
                    <div>
                        <label class="text-sm font-medium text-gray-600 mb-1 block">السعر *</label>
                        <input 
                            wire:model="items.{{ $index }}.unit_price"
                            type="number" min="0" step="0.01"
                            class="w-32 bg-white border border-gray-300 rounded-xl p-2.5 text-center focus:ring-blue-500"
                            placeholder="السعر"
                        >
                        @error("items.$index.unit_price")
                            <span class="text-red-600 text-xs">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remove -->
                    <button 
                        type="button" 
                        wire:click="removeItem({{ $index }})"
                        class="text-red-600 font-bold text-xl px-2 hover:text-red-700"
                    >
                        ×
                    </button>

                </div>

                @endforeach

                <button 
                    type="button"
                    wire:click="addItem"
                    class="text-blue-600 text-sm font-medium hover:underline"
                >
                    + إضافة صنف
                </button>

            </div>

            <!-- Notes -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700">ملاحظات</label>
                <textarea 
                    wire:model="notes"
                    rows="2"
                    class="w-full bg-gray-50 border border-gray-300 rounded-xl p-2.5 focus:ring-blue-500"
                ></textarea>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">

                <a 
                    href="{{ route('admin.sales-invoices.index') }}"
                    class="bg-gray-100 px-5 py-2.5 rounded-xl hover:bg-gray-200"
                >
                    إلغاء
                </a>

                <button 
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-xl hover:bg-blue-700"
                >
                    حفظ
                </button>

            </div>

        </form>

    </div>
</div>
