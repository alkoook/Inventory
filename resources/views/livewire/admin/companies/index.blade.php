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
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <a href="{{ route('admin.companies.create') }}" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة شركة جديدة
            </a>
        </div>

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
                                <a href="{{ route('admin.companies.edit', $company->id) }}" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">تعديل</a>
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
</div>
