<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-800">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث عن صنف..." class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-10 transition-all">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-500/50 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-all shadow-lg">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة صنف جديد
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-300">
                <thead class="bg-slate-800/50 text-xs uppercase text-gray-400 border-b border-slate-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الوصف</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">تاريخ الإضافة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-100">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ Str::limit($category->description, 50) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/50' : 'bg-red-500/20 text-red-400 border border-red-500/50' }}" style="{{ $category->is_active ? 'box-shadow: 0 0 10px rgba(34, 197, 94, 0.2);' : 'box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);' }}">
                                    {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-400">{{ $category->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 flex gap-3">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="font-medium text-blue-400 hover:text-blue-300 transition-colors">تعديل</a>
                                <button wire:click="delete({{ $category->id }})" wire:confirm="هل أنت متأكد من حذف هذا الصنف؟" class="font-medium text-red-400 hover:text-red-300 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                لا توجد أصناف مضافة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-700/50">
            {{ $categories->links() }}
        </div>
    </div>
</div>
