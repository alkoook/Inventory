<div>
<<<<<<< HEAD
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
=======
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
        </div>
    @endif

<<<<<<< HEAD
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
=======
    <!-- Header with Search and Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="flex-1 w-full sm:w-auto">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="البحث عن شركة..."
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <button 
            wire:click="create"
            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            إضافة شركة جديدة
        </button>
    </div>

    <!-- Companies Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">اسم الشركة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">جهة الاتصال</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">معلومات الاتصال</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($companies as $company)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $company->name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $company->contact_name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-slate-900">{{ $company->phone ?? '-' }}</div>
                            <div class="text-sm text-slate-500">{{ $company->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($company->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    نشط
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    غير نشط
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <button 
                                    wire:click="edit({{ $company->id }})"
                                    class="text-blue-600 hover:text-blue-900 transition"
                                >
                                    تعديل
                                </button>
                                <button 
                                    wire:click="delete({{ $company->id }})"
                                    wire:confirm="هل أنت متأكد من حذف هذه الشركة؟"
                                    class="text-red-600 hover:text-red-900 transition"
                                >
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            لا توجد شركات
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $companies->links() }}
    </div>

    <!-- Modal -->
    @if ($selected_id !== null || $name !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">
                        {{ $selected_id ? 'تعديل بيانات الشركة' : 'إضافة شركة جديدة' }}
                    </h3>
                    <button wire:click="$set('selected_id', null); $set('name', null)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit="save" class="p-6 space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700 mb-2">اسم الشركة</label>
                        <input 
                            type="text" 
                            id="name" 
                            wire:model="name"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-slate-700 mb-2">اسم المسؤول</label>
                        <input 
                            type="text" 
                            id="contact_name" 
                            wire:model="contact_name"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                        @error('contact_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-slate-700 mb-2">رقم الهاتف</label>
                            <input 
                                type="text" 
                                id="phone" 
                                wire:model="phone"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">البريد الإلكتروني</label>
                            <input 
                                type="email" 
                                id="email" 
                                wire:model="email"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-slate-700 mb-2">العنوان</label>
                        <textarea 
                            id="address" 
                            wire:model="address" 
                            rows="2"
                            class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        ></textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center">
                        <input 
                            id="is_active" 
                            type="checkbox" 
                            wire:model="is_active"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                        >
                        <label for="is_active" class="mr-2 text-sm font-medium text-slate-700">نشط</label>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex gap-3 pt-4">
                        <button 
                            type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition"
                        >
                            {{ $selected_id ? 'تحديث' : 'إضافة' }}
                        </button>
                        <button 
                            type="button"
                            wire:click="$set('selected_id', null); $set('name', null)"
                            class="flex-1 bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2 rounded-lg font-medium transition"
                        >
                            إلغاء
                        </button>
                    </div>
                </form>
            </div>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
        </div>
    @endif
</div>
