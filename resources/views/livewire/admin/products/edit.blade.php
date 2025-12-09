<div>
    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
            <h2 class="text-xl font-bold mb-6 text-gray-100">تعديل المنتج</h2>
            
            <form wire:submit="save" class="space-y-4">
                <div class="col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-300">صورة المنتج</label>
                    <div class="flex items-center gap-4">
                        @if($image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-xl border-2 border-blue-500/50 shadow-lg">
                            </div>
                        @elseif($oldImage)
                            <div class="relative">
                                <img src="{{ asset('storage/' . $oldImage) }}" alt="Current" class="w-32 h-32 object-cover rounded-xl border-2 border-blue-500/50 shadow-lg">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input wire:model="image" type="file" accept="image/*" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer bg-slate-700/50 border border-slate-600 rounded-xl p-2.5">
                            @error('image') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-400 mt-2">الحجم الأقصى: 2MB</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label class="block mb-2 text-sm font-medium text-gray-300">اسم المنتج *</label>
                        <input wire:model="name" type="text" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">SKU *</label>
                        <input wire:model="sku" type="text" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('sku') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">الصنف *</label>
                        <select wire:model="category_id" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">اختر...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">الشركة</label>
                        <select wire:model="company_id" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option value="">بدون شركة</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">سعر الشراء *</label>
                        <input wire:model="purchase_price" type="number" step="0.01" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('purchase_price') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">سعر البيع *</label>
                        <input wire:model="sale_price" type="number" step="0.01" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        @error('sale_price') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">المخزون الحالي (للقراءة فقط)</label>
                        <input type="number" value="{{ $stock }}" readonly class="w-full bg-slate-700/30 border border-slate-600 text-gray-400 rounded-xl p-2.5 cursor-not-allowed">
                        <p class="text-xs text-gray-500 mt-1">لا يمكن تعديل المخزون من هنا. استخدم فواتير الشراء/البيع لتعديل المخزون.</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">حد إعادة الطلب</label>
                        <input wire:model="reorder_level" type="number" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                    </div>
                    <div class="col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-300">الوصف</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <a href="{{ route('admin.products.index') }}" class="bg-slate-700/50 hover:bg-slate-700 text-gray-300 px-5 py-2.5 rounded-xl transition-colors">إلغاء</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl transition-all shadow-lg">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>
