<div>
    <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg shadow-black/20 overflow-hidden">
        <div class="p-6 border-b border-slate-700 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث عن شركة..." class="w-full bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <button wire:click="create" onclick="document.getElementById('companyModal').showModal()" class="w-full sm:w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة شركة جديدة
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-400">
                <thead class="bg-slate-900/50 text-xs uppercase text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-medium">البريد الإلكتروني</th>
                        <th scope="col" class="px-6 py-4 font-medium">الهاتف</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700">
                    @forelse($companies as $company)
                        <tr class="hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-white">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-700 flex items-center justify-center text-lg">🏢</div>
                                    {{ $company->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $company->email ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $company->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $company->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                    {{ $company->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $company->id }})" onclick="document.getElementById('companyModal').showModal()" class="font-medium text-cyan-400 hover:text-cyan-300 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $company->id }})" wire:confirm="هل أنت متأكد من حذف هذه الشركة؟" class="font-medium text-red-400 hover:text-red-300 transition-colors">حذف</button>
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
        
        <div class="p-4 border-t border-slate-700">
            {{ $companies->links() }}
        </div>
    </div>

    <!-- Modal -->
    <dialog id="companyModal" class="modal bg-slate-900/80 backdrop-blur-sm fixed inset-0 z-50 w-full h-full flex items-center justify-center p-4" wire:ignore.self>
        <div class="bg-slate-800 rounded-2xl shadow-2xl border border-slate-700 w-full max-w-2xl p-6 relative overflow-y-auto max-h-[90vh]">
            <h3 class="text-xl font-bold text-white mb-6">
                {{ $selected_id ? 'تعديل بيانات الشركة' : 'إضافة شركة جديدة' }}
            </h3>
            
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-300">اسم الشركة</label>
                        <input type="text" id="name" wire:model="name" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="اسم الشركة">
                        @error('name') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-300">البريد الإلكتروني</label>
                        <input type="email" id="email" wire:model="email" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="example@company.com">
                        @error('email') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-300">رقم الهاتف</label>
                        <input type="text" id="phone" wire:model="phone" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="05xxxxxxxx">
                        @error('phone') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-300">العنوان</label>
                        <input type="text" id="address" wire:model="address" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="المدينة، الحي...">
                        @error('address') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-300">وصف الشركة</label>
                        <textarea id="description" wire:model="description" rows="3" class="bg-slate-900 border border-slate-600 text-white text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5" placeholder="نبذة عن الشركة..."></textarea>
                        @error('description') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center mt-4">
                    <input id="company_is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-cyan-600 bg-slate-900 border-slate-600 rounded focus:ring-cyan-500 focus:ring-2">
                    <label for="company_is_active" class="mr-2 text-sm font-medium text-gray-300">نشط (تظهر في القوائم)</label>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('companyModal').close()" class="text-gray-300 bg-slate-700 hover:bg-slate-600 focus:ring-4 focus:outline-none focus:ring-slate-500 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</button>
                    <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">حفظ</button>
                </div>
            </form>
            
            <button onclick="document.getElementById('companyModal').close()" class="absolute top-4 left-4 text-gray-400 hover:text-white">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </dialog>

    <script>
        window.addEventListener('close-modal', event => {
            document.getElementById('companyModal').close();
        })
    </script>
</div>
