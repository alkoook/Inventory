<div>
    <div class="max-w-4xl mx-auto bg-white rounded-2xl border p-6">
        <h2 class="text-xl font-bold mb-6">إنشاء فاتورة مبيعات</h2>
        
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium">الزبون *</label>
                    <select wire:model="customer_id" class="w-full bg-gray-50 border rounded-xl p-2.5">
                        <option value="">اختر...</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium">التاريخ *</label>
                    <input wire:model="invoice_date" type="date" class="w-full bg-gray-50 border rounded-xl p-2.5">
                    @error('invoice_date') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="border rounded-xl p-4">
                <h3 class="font-semibold mb-3">الأصناف</h3>
                @foreach($items as $index => $item)
                    <div class="flex gap-2 mb-2">
                        <select wire:model.live="items.{{ $index }}.product_id" class="flex-1 bg-gray-50 border rounded-xl p-2">
                            <option value="">اختر منتج...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->stock }})</option>
                            @endforeach
                        </select>
                        <input wire:model="items.{{ $index }}.quantity" type="number" placeholder="الكمية" class="w-24 bg-gray-50 border rounded-xl p-2">
                        <input wire:model="items.{{ $index }}.unit_price" type="number" step="0.01" placeholder="السعر" class="w-32 bg-gray-50 border rounded-xl p-2">
                        <button type="button" wire:click="removeItem({{ $index }})" class="text-red-600 px-3">×</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addItem" class="text-blue-600 text-sm mt-2">+ إضافة صنف</button>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium">ملاحظات</label>
                <textarea wire:model="notes" rows="2" class="w-full bg-gray-50 border rounded-xl p-2.5"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('admin.sales-invoices.index') }}" class="bg-gray-100 px-5 py-2.5 rounded-xl">إلغاء</a>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2.5 rounded-xl">حفظ</button>
            </div>
        </form>
    </div>
</div>
