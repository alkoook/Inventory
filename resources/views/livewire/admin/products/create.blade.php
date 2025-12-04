<div>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border shadow-sm p-6">
            <h2 class="text-xl font-bold mb-6">إضافة منتج جديد</h2>
            
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-2 text-sm font-medium">اسم المنتج *</label>
                        <input wire:model="name" type="text" class="w-full bg-gray-50 border rounded-xl p-2.5">
                        @error('name') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">SKU *</label>
                        <input wire:model="sku" type="text" class="w-full bg-gray-50 border rounded-xl p-2.5">
                        @error('sku') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">الصنف *</label>
                        <select wire:model="category_id" class="w-full bg-gray-50 border rounded-xl p-2.5">
                            <option value="">اختر...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">الشركة *</label>
                        <select wire:model="company_id" class="w-full bg-gray-50 border rounded-xl p-2.5">
                            <option value="">اختر...</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">سعر الشراء *</label>
                        <input wire:model="purchase_price" type="number" step="0.01" class="w-full bg-gray-50 border rounded-xl p-2.5">
                        @error('purchase_price') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">سعر البيع *</label>
                        <input wire:model="sale_price" type="number" step="0.01" class="w-full bg-gray-50 border rounded-xl p-2.5">
                        @error('sale_price') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">المخزون الأولي *</label>
                        <input wire:model="stock" type="number" class="w-full bg-gray-50 border rounded-xl p-2.5">
                        @error('stock') <span class="text-red-600 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium">حد إعادة الطلب</label>
                        <input wire:model="reorder_level" type="number" class="w-full bg-gray-50 border rounded-xl p-2.5">
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium">الوصف</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-gray-50 border rounded-xl p-2.5"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.products.index') }}" class="bg-gray-100 hover:bg-gray-200 px-5 py-2.5 rounded-xl">إلغاء</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
