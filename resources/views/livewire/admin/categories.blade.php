<div>
    <div class="bg-white rounded-lg border border-slate-200">
        <div class="p-6 border-b border-slate-200 flex justify-between items-center">
            <div>
                <h2 class="text-lg font-bold text-slate-800">الأصناف</h2>
                <p class="text-sm text-slate-600 mt-1">إدارة أصناف المنتجات</p>
            </div>
            <button wire:click="create" onclick="document.getElementById('categoryModal').showModal()" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700">
                إضافة صنف
            </button>
        </div>

        <div class="p-6 border-b border-slate-200">
            <input wire:model.live="search" type="text" placeholder="بحث..." class="w-full md:w-64 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">الوصف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">الحالة</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $category->description ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $category->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <button wire:click="edit({{ $category->id }})" onclick="document.getElementById('categoryModal').showModal()" class="text-blue-600 hover:text-blue-800 ml-3">تعديل</button>
                                <button wire:click="delete({{ $category->id }})" wire:confirm="هل أنت متأكد؟" class="text-red-600 hover:text-red-800">حذف</button>
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
        
        <div class="p-4 border-t border-slate-200">
            {{ $categories->links() }}
        </div>
    </div>

    <!-- Modal -->
    <dialog id="categoryModal" class="rounded-lg p-0 backdrop:bg-black/50" wire:ignore.self>
        <div class="bg-white rounded-lg w-full max-w-md">
            <div class="p-6 border-b border-slate-200">
                <h3 class="text-lg font-bold text-slate-800">
                    {{ $selected_id ? 'تعديل الصنف' : 'إضافة صنف جديد' }}
                </h3>
            </div>
            
            <form wire:submit="save" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">اسم الصنف</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">الوصف</label>
                    <textarea wire:model="description" rows="3" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" wire:model="is_active" class="w-4 h-4 text-slate-600 border-slate-300 rounded">
                    <label class="mr-2 text-sm text-slate-700">نشط</label>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('categoryModal').close()" class="px-4 py-2 text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200">
                        إلغاء
                    </button>
                    <button type="submit" class="px-4 py-2 bg-slate-800 text-white rounded-lg hover:bg-slate-700">
                        حفظ
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        window.addEventListener('close-modal', event => {
            document.getElementById('categoryModal').close();
        })
    </script>
</div>
