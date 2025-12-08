<div>
    <div class="max-w-4xl mx-auto bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700/50 shadow-xl p-6" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
        <h2 class="text-xl font-bold mb-6 text-gray-100">إنشاء فاتورة مشتريات</h2>
        
        <form wire:submit="save" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">الشركة *</label>
                    <select wire:model="company_id" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">اختر...</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('company_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">التاريخ *</label>
                    <input wire:model="invoice_date" type="date" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    @error('invoice_date') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="border border-slate-700/50 rounded-xl p-4 bg-slate-700/30">
                <h3 class="font-semibold mb-3 text-gray-200">الأصناف</h3>
                @foreach($items as $index => $item)
                    <div class="flex flex-wrap gap-2 mb-2">
                        <select wire:model.live="items.{{ $index }}.product_id" class="flex-1 min-w-[200px] bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر منتج...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->stock }})</option>
                            @endforeach
                        </select>
                        <input wire:model="items.{{ $index }}.quantity" type="number" placeholder="الكمية" class="w-24 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <select wire:model="items.{{ $index }}.unit_of_measure" class="w-32 bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="غرام">غرام</option>
                            <option value="كيلو">كيلو</option>
                            <option value="قطعة">قطعة</option>
                            <option value="علبة">علبة</option>
                            <option value="كيس">كيس</option>
                            <option value="ظرف">ظرف</option>
                            <option value="تنكة">تنكة</option>
                        </select>
                        <input wire:model="items.{{ $index }}.unit_price" type="number" step="0.01" placeholder="السعر" class="w-32 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <button type="button" wire:click="removeItem({{ $index }})" class="text-red-400 hover:text-red-300 px-3 transition-colors">×</button>
                    </div>
                @endforeach
                <button type="button" wire:click="addItem" class="text-blue-400 hover:text-blue-300 text-sm mt-2 transition-colors">+ إضافة صنف</button>
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">ملاحظات</label>
                <textarea wire:model="notes" rows="2" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"></textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                <a href="{{ route('admin.purchase-invoices.index') }}" class="bg-slate-700/50 hover:bg-slate-700 text-gray-300 px-5 py-2.5 rounded-xl transition-colors">إلغاء</a>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-5 py-2.5 rounded-xl transition-all shadow-lg" style="box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">حفظ</button>
            </div>
        </form>
    </div>
</div>
