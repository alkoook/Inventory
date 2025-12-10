<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
            <div class="p-6 border-b border-slate-700/50 bg-slate-800">
                <h2 class="text-xl font-bold text-gray-100">إضافة صنف جديد</h2>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">صورة الصنف</label>
                    <div class="flex items-center gap-4">
                        @if($image)
                            <div class="relative">
                                <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-xl border-2 border-blue-500/50 shadow-lg">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input wire:model="image" type="file" accept="image/*" class="w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:cursor-pointer bg-slate-700/50 border border-slate-600 rounded-xl p-2.5">
                            @error('image') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            <p class="text-xs text-gray-400 mt-2">الحجم الأقصى: 10MB</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-300">اسم الصنف *</label>
                    <input type="text" id="name" wire:model="name" class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all" placeholder="مثال: إلكترونيات">
                    @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-300">الوصف</label>
                    <textarea id="description" wire:model="description" rows="3" class="bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-all" placeholder="وصف مختصر للصنف..."></textarea>
                    @error('description') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input id="is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 bg-slate-700/50 border-slate-600 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="mr-2 text-sm font-medium text-gray-300">نشط (يظهر في المتجر)</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <a href="{{ route('admin.categories.index') }}" class="text-gray-300 bg-slate-700/50 hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-500 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</a>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500/50 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-all shadow-lg">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
