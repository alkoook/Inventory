<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث عن شركة..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <button wire:click="create" onclick="document.getElementById('companyModal').showModal()" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة شركة جديدة
            </button>
        </div>
    @endif

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-700">
                <thead class="bg-gray-50 text-xs uppercase text-gray-600 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-semibold">البريد الإلكتروني</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الهاتف</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($companies as $company)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-lg">🏢</div>
                                    {{ $company->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->email ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $company->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $company->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $company->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $company->id }})" onclick="document.getElementById('companyModal').showModal()" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $company->id }})" wire:confirm="هل أنت متأكد من حذف هذه الشركة؟" class="font-medium text-red-600 hover:text-red-700 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                لا توجد شركات مضافة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $companies->links() }}
        </div>
    </div>

    <!-- Modal -->
    <dialog id="companyModal" class="modal bg-gray-900/50 backdrop-blur-sm fixed inset-0 z-50 w-full h-full flex items-center justify-center p-4" wire:ignore.self>
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                {{ $selected_id ? 'تعديل بيانات الشركة' : 'إضافة شركة جديدة' }}
            </h3>
            
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">اسم الشركة *</label>
                        <input type="text" id="name" wire:model="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="اسم الشركة">
                        @error('name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-700">البريد الإلكتروني</label>
                        <input type="email" id="email" wire:model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="example@company.com">
                        @error('email') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-700">رقم الهاتف</label>
                        <input type="text" id="phone" wire:model="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="05xxxxxxxx">
                        @error('phone') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-700">العنوان</label>
                        <input type="text" id="address" wire:model="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="المدينة، الحي...">
                        @error('address') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-700">وصف الشركة</label>
                        <textarea id="description" wire:model="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="نبذة عن الشركة..."></textarea>
                        @error('description') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input id="company_is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="company_is_active" class="mr-2 text-sm font-medium text-gray-700">نشط (تظهر في القوائم)</label>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" onclick="document.getElementById('companyModal').close()" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</button>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">حفظ</button>
                </div>
            </form>
            
            <button onclick="document.getElementById('companyModal').close()" class="absolute top-4 left-4 text-gray-400 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
</div>
