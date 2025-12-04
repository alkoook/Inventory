<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex justify-between items-center">
            <input wire:model.live="search" type="text" placeholder="بحث..." class="w-64 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl p-2.5">
            <a href="{{ route('admin.products.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-xl text-sm px-5 py-2.5">إضافة منتج</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">الاسم</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">الصنف</th>
                        <th class="px-6 py-4">المخزون</th>
                        <th class="px-6 py-4">السعر</th>
                        <th class="px-6 py-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->sku }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs {{ $product->stock > $product->reorder_level ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold">${{ number_format($product->sale_price, 2) }}</td>
                            <td class="px-6 py-4 flex gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-700">تعديل</a>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="هل أنت متأكد؟" class="text-red-600 hover:text-red-700">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">لا توجد منتجات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t">
            {{ $products->links() }}
        </div>
    </div>
</div>
