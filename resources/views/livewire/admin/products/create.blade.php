<div>
    <div class="max-w-5xl mx-auto">
        <div class="bg-slate-800 border border-slate-700/50 shadow-xl rounded-2xl p-8">
            <h2 class="text-2xl font-bold mb-8 text-gray-100 flex items-center gap-3">
                <div class="p-2 rounded-lg bg-blue-500/20 text-blue-400">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                إضافة منتج جديد
            </h2>
            
            <form wire:submit="save" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-300">صورة المنتج</label>
                        <div class="flex items-center gap-4">
                            @if($image)
                                <div class="relative">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-xl border-2 border-blue-500/50 shadow-lg">
                                </div>
                            @endif
                            <div class="flex-1">
                                <input wire:model="image" type="file" accept="image/*" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer bg-slate-700/50 border border-slate-600 rounded-xl p-2.5">
                                @error('image') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                <p class="text-xs text-gray-400 mt-2">الحجم الأقصى: 2MB</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">اسم المنتج *</label>
                        <input wire:model="name" type="text" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">SKU *</label>
                        <input wire:model="sku" type="text" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('sku') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">الصنف *</label>
                        <select wire:model="category_id" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="">اختر...</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">الشركة</label>
                        <select wire:model="company_id" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="">بدون شركة</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">سعر الشراء *</label>
                        <input wire:model="purchase_price" type="number" step="0.01" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('purchase_price') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">سعر البيع *</label>
                        <input wire:model="sale_price" type="number" step="0.01" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('sale_price') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">المخزون الأولي *</label>
                        <input wire:model="stock" type="number" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('stock') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">حد إعادة الطلب</label>
                        <input wire:model="reorder_level" type="number" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-300">وحدة القياس *</label>
                        <select wire:model="unit_of_measure" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="غرام">غرام</option>
                            <option value="كيلو">كيلو</option>
                            <option value="قطعة">قطعة</option>
                            <option value="علبة">علبة</option>
                            <option value="كيس">كيس</option>
                            <option value="ظرف">ظرف</option>
                            <option value="تنكة">تنكة</option>
                            <option value="طرد">طرد</option>
                        </select>
                        @error('unit_of_measure') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-300">الوصف</label>
                        <textarea wire:model="description" rows="4" class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-slate-700/50">
                    <a href="{{ route('admin.products.index') }}" class="bg-slate-700 hover:bg-slate-600 text-gray-100 px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">إلغاء</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        حفظ المنتج
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
