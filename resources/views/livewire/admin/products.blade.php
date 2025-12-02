<div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث عن منتج..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <button wire:click="create" onclick="document.getElementById('productModal').showModal()" class="w-full sm:w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة منتج جديد
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">المنتج</th>
                        <th scope="col" class="px-6 py-4 font-medium">الصنف / الشركة</th>
                        <th scope="col" class="px-6 py-4 font-medium">السعر (شراء / بيع)</th>
                        <th scope="col" class="px-6 py-4 font-medium">المخزون</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                <div class="text-xs text-gray-400">{{ $product->sku }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-900">{{ $product->category->name ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $product->company->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-emerald-600 font-bold">{{ number_format($product->sale_price, 2) }}</div>
                                <div class="text-xs text-gray-400">{{ number_format($product->purchase_price, 2) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="{{ $product->stock <= $product->reorder_level ? 'text-red-600 font-bold' : 'text-gray-900' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $product->id }})" onclick="document.getElementById('productModal').showModal()" class="font-medium text-cyan-600 hover:text-cyan-700 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="هل أنت متأكد من حذف هذا المنتج؟" class="font-medium text-red-600 hover:text-red-700 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                لا توجد منتجات مضافة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Modal -->
    <dialog id="productModal" class="modal bg-gray-900/50 backdrop-blur-sm fixed inset-0 z-50 w-full h-full flex items-center justify-center p-4" wire:ignore.self>
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-2xl p-6 relative max-h-[90vh] overflow-y-auto">
            <h3 class="text-xl font-bold text-gray-900 mb-6">
                {{ $selected_id ? 'تعديل المنتج' : 'إضافة منتج جديد' }}
            </h3>
            
            <form wire:submit="save" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">اسم المنتج</label>
                        <input type="text" id="name" wire:model="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="sku" class="block mb-2 text-sm font-medium text-gray-700">رمز المنتج (SKU)</label>
                        <input type="text" id="sku" wire:model="sku" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                        @error('sku') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-700">الصنف</label>
                        <select id="category_id" wire:model="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                            <option value="">اختر الصنف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="company_id" class="block mb-2 text-sm font-medium text-gray-700">الشركة المصنعة</label>
                        <select id="company_id" wire:model="company_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                            <option value="">اختر الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-700">سعر الشراء</label>
                        <input type="number" step="0.01" id="purchase_price" wire:model="purchase_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                        @error('purchase_price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="sale_price" class="block mb-2 text-sm font-medium text-gray-700">سعر البيع</label>
                        <input type="number" step="0.01" id="sale_price" wire:model="sale_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                        @error('sale_price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-700">الكمية المتوفرة</label>
                        <input type="number" id="stock" wire:model="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                        @error('stock') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <label for="reorder_level" class="block mb-2 text-sm font-medium text-gray-700">حد إعادة الطلب</label>
                        <input type="number" id="reorder_level" wire:model="reorder_level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                        @error('reorder_level') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-700">الوصف</label>
                        <textarea id="description" wire:model="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5"></textarea>
                        @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="md:col-span-2 flex items-center">
                        <input id="is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-cyan-600 bg-gray-100 border-gray-300 rounded focus:ring-cyan-500 focus:ring-2">
                        <label for="is_active" class="mr-2 text-sm font-medium text-gray-700">نشط (يظهر في المتجر)</label>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('productModal').close()" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</button>
                    <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">حفظ</button>
                </div>
            </form>
            
            <button onclick="document.getElementById('productModal').close()" class="absolute top-4 left-4 text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </dialog>

    <script>
        window.addEventListener('close-modal', event => {
            document.getElementById('productModal').close();
        })
    </script>
</div>
