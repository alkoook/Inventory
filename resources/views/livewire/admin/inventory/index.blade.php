<div>
    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">إدارة المخزون</h2>
            <input wire:model.live="search" type="text" placeholder="بحث عن منتج..." class="w-64 bg-gray-50 border rounded-xl p-2.5">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">المنتج</th>
                        <th class="px-6 py-4">SKU</th>
                        <th class="px-6 py-4">الكمية الحالية</th>
                        <th class="px-6 py-4">حد إعادة الطلب</th>
                        <th class="px-6 py-4">الحالة</th>
                        <th class="px-6 py-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->sku }}</td>
                            <td class="px-6 py-4 font-bold text-lg">{{ $product->stock }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $product->reorder_level ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($product->stock <= 0)
                                    <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">نفذت الكمية</span>
                                @elseif($product->stock <= $product->reorder_level)
                                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">منخفض</span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">متوفر</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-700">تعديل المخزون</a>
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
