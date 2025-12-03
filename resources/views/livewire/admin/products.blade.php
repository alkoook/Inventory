<div>
<<<<<<< HEAD
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
=======
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
            {{ session('message') }}
        </div>
    @endif

<<<<<<< HEAD
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث عن منتج..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <button wire:click="create" onclick="document.getElementById('productModal').showModal()" class="w-full sm:w-auto text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إضافة منتج جديد
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-700">
                <thead class="bg-gray-50 text-xs uppercase text-gray-600 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">الاسم</th>
                        <th scope="col" class="px-6 py-4 font-semibold">رمز المنتج</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الصنف</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الشركة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">سعر الشراء</th>
                        <th scope="col" class="px-6 py-4 font-semibold">سعر البيع</th>
                        <th scope="col" class="px-6 py-4 font-semibold">المخزون</th>
                        <th scope="col" class="px-6 py-4 font-semibold">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->sku }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->category?->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->company?->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ number_format($product->purchase_price, 2) }} ر.س</td>
                            <td class="px-6 py-4 text-gray-900 font-semibold">{{ number_format($product->sale_price, 2) }} ر.س</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->stock > $product->reorder_level ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $product->id }})" onclick="document.getElementById('productModal').showModal()" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="هل أنت متأكد من حذف هذا المنتج؟" class="font-medium text-red-600 hover:text-red-700 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">
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
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-700">اسم المنتج *</label>
                        <input type="text" id="name" wire:model="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="مثال: لابتوب HP">
                        @error('name') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="sku" class="block mb-2 text-sm font-medium text-gray-700">رمز المنتج (SKU) *</label>
                        <input type="text" id="sku" wire:model="sku" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="مثال: HP-001">
                        @error('sku') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-700">الوصف</label>
                    <textarea id="description" wire:model="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="وصف مختصر للمنتج..."></textarea>
                    @error('description') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-700">الصنف *</label>
                        <select id="category_id" wire:model="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">اختر الصنف</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="company_id" class="block mb-2 text-sm font-medium text-gray-700">الشركة *</label>
                        <select id="company_id" wire:model="company_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">اختر الشركة</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="purchase_price" class="block mb-2 text-sm font-medium text-gray-700">سعر الشراء *</label>
                        <input type="number" step="0.01" id="purchase_price" wire:model="purchase_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="0.00">
                        @error('purchase_price') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="sale_price" class="block mb-2 text-sm font-medium text-gray-700">سعر البيع *</label>
                        <input type="number" step="0.01" id="sale_price" wire:model="sale_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="0.00">
                        @error('sale_price') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="stock" class="block mb-2 text-sm font-medium text-gray-700">الكمية في المخزون *</label>
                        <input type="number" id="stock" wire:model="stock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="0">
                        @error('stock') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="reorder_level" class="block mb-2 text-sm font-medium text-gray-700">حد إعادة الطلب *</label>
                        <input type="number" id="reorder_level" wire:model="reorder_level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="0">
                        @error('reorder_level') <span class="text-red-600 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="is_active" type="checkbox" wire:model="is_active" class="w-4 h-4 text-blue-600 bg-gray-50 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    <label for="is_active" class="mr-2 text-sm font-medium text-gray-700">نشط (يظهر في المتجر)</label>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200">
                    <button type="button" onclick="document.getElementById('productModal').close()" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">إلغاء</button>
                    <button type="submit" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">حفظ</button>
                </div>
            </form>
            
            <button onclick="document.getElementById('productModal').close()" class="absolute top-4 left-4 text-gray-400 hover:text-gray-900">
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
=======
    <!-- Header with Search and Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="flex-1 w-full sm:w-auto">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="البحث عن منتج..."
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
            إضافة منتج جديد
        </button>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">المنتج</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الصنف / الشركة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">السعر (شراء / بيع)</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">المخزون</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($products as $product)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $product->name }}</div>
                            <div class="text-sm text-slate-500">{{ $product->sku }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $product->category?->name ?? '-' }}</div>
                            <div class="text-sm text-slate-500">{{ $product->company?->name ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-blue-600">{{ number_format($product->sale_price, 2) }}</div>
                            <div class="text-sm text-slate-500">{{ number_format($product->purchase_price, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm {{ $product->stock <= $product->reorder_level ? 'text-red-600 font-bold' : 'text-slate-900' }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($product->is_active)
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
                                    wire:click="edit({{ $product->id }})"
                                    class="text-blue-600 hover:text-blue-900 transition"
                                >
                                    تعديل
                                </button>
                                <button 
                                    wire:click="delete({{ $product->id }})"
                                    wire:confirm="هل أنت متأكد من حذف هذا المنتج؟"
                                    class="text-red-600 hover:text-red-900 transition"
                                >
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            لا توجد منتجات
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links() }}
    </div>

    <!-- Modal -->
    @if ($selected_id !== null || $name !== null)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">
                        {{ $selected_id ? 'تعديل المنتج' : 'إضافة منتج جديد' }}
                    </h3>
                    <button wire:click="$set('selected_id', null); $set('name', null)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <form wire:submit="save" class="p-6 space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-medium text-slate-700 mb-2">اسم المنتج</label>
                            <input 
                                type="text" 
                                id="name" 
                                wire:model="name"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- SKU -->
                        <div>
                            <label for="sku" class="block text-sm font-medium text-slate-700 mb-2">رمز المنتج (SKU)</label>
                            <input 
                                type="text" 
                                id="sku" 
                                wire:model="sku"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('sku') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-slate-700 mb-2">الصنف</label>
                            <select 
                                id="category_id" 
                                wire:model="category_id"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">اختر الصنف</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Company -->
                        <div>
                            <label for="company_id" class="block text-sm font-medium text-slate-700 mb-2">الشركة</label>
                            <select 
                                id="company_id" 
                                wire:model="company_id"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">اختر الشركة</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Purchase Price -->
                        <div>
                            <label for="purchase_price" class="block text-sm font-medium text-slate-700 mb-2">سعر الشراء</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                id="purchase_price" 
                                wire:model="purchase_price"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('purchase_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Sale Price -->
                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-slate-700 mb-2">سعر البيع</label>
                            <input 
                                type="number" 
                                step="0.01" 
                                id="sale_price" 
                                wire:model="sale_price"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('sale_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Stock -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-slate-700 mb-2">الكمية المتوفرة</label>
                            <input 
                                type="number" 
                                id="stock" 
                                wire:model="stock"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Reorder Level -->
                        <div>
                            <label for="reorder_level" class="block text-sm font-medium text-slate-700 mb-2">حد إعادة الطلب</label>
                            <input 
                                type="number" 
                                id="reorder_level" 
                                wire:model="reorder_level"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                            @error('reorder_level') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">الوصف</label>
                            <textarea 
                                id="description" 
                                wire:model="description" 
                                rows="3"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            ></textarea>
                            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="md:col-span-2 flex items-center">
                            <input 
                                id="is_active" 
                                type="checkbox" 
                                wire:model="is_active"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                            >
                            <label for="is_active" class="mr-2 text-sm font-medium text-slate-700">نشط (يظهر في المتجر)</label>
                        </div>
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
        </div>
    @endif
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
</div>
