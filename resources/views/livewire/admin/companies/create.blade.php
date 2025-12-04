<div>
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">إضافة شركة جديدة</h2>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">اسم الشركة *</label>
                        <input type="text" id="name" wire:model="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="اسم الشركة">
                        @error('name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block mb-2 text-sm font-medium text-gray-700">جهة الاتصال</label>
                        <input type="text" id="contact_name" wire:model="contact_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="اسم جهة الاتصال">
                        @error('contact_name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                        <input type="email" id="email" wire:model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="example@company.com">
                        @error('email') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">رقم الهاتف</label>
                        <input type="text" id="phone" wire:model="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="05xxxxxxxx">
                        @error('phone') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" id="address" wire:model="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="المدينة، الحي...">
                        @error('address') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="mr-2 text-sm font-medium text-gray-700">نشط (تظهر في القوائم)</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('admin.companies.index') }}" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</a>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>
