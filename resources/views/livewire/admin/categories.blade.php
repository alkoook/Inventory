<div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث عن صنف..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <button wire:click="create" onclick="document.getElementById('categoryModal').showModal()" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة صنف جديد
            </button>
        </div>

        <div class="p-6 border-b border-slate-200">
            <input wire:model.live="search" type="text" placeholder="بحث..." class="w-full md:w-64 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-700">
                <thead class="bg-gray-50 text-xs uppercase text-gray-600 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الوصف</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">تاريخ الإضافة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ Str::limit($category->description, 50) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $category->created_at}}</td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $category->id }})" onclick="document.getElementById('categoryModal').showModal()" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $category->id }})" wire:confirm="هل أنت متأكد من حذف هذا الصنف؟" class="font-medium text-red-600 hover:text-red-700 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-500">
                                لا توجد أصناف
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Modal -->
    <dialog id="categoryModal" class="modal bg-gray-900/50 backdrop-blur-sm fixed inset-0 z-50 w-full h-full flex items-center justify-center p-4" wire:ignore.self>
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-md p-6 relative">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                {{ $selected_id ? 'تعديل الصنف' : 'إضافة صنف جديد' }}
            </h3>
            
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">اسم الصنف</label>
                    <input type="text" id="name" wire:model="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="مثال: إلكترونيات">
                    @error('name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700">الوصف</label>
                    <textarea id="description" wire:model="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="وصف مختصر للصنف..."></textarea>
                    @error('description') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input id="is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="mr-2 text-sm font-medium text-gray-700">نشط (يظهر في المتجر)</label>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('categoryModal').close()" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</button>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">حفظ</button>
                </div>
            </form>
            
            <button onclick="document.getElementById('categoryModal').close()" class="absolute top-4 left-4 text-gray-400 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </dialog>

    <script>
        window.addEventListener('close-modal', event => {
            document.getElementById('categoryModal').close();
        })
    </script>
</div>
