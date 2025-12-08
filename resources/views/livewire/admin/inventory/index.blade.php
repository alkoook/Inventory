<div>
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(239, 68, 68, 0.03) 100%);">
            <h2 class="text-xl font-bold text-gray-100">إدارة المخزون</h2>
            <input wire:model.live="search" type="text" placeholder="بحث عن منتج..." class="w-full sm:w-64 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-300">
                <thead class="bg-slate-800/50 border-b border-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-gray-400 font-semibold">المنتج</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">SKU</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الكمية الحالية</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">حد إعادة الطلب</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الحالة</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-100">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->sku }}</td>
                            <td class="px-6 py-4 font-bold text-lg text-gray-100">{{ $product->stock }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->reorder_level ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($product->stock <= 0)
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/50" style="box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);">نفذت الكمية</span>
                                @elseif($product->stock <= $product->reorder_level)
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/50" style="box-shadow: 0 0 10px rgba(251, 191, 36, 0.2);">منخفض</span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/50" style="box-shadow: 0 0 10px rgba(34, 197, 94, 0.2);">متوفر</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">تعديل المخزون</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">لا توجد منتجات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-700/50">
            {{ $products->links() }}
        </div>
    </div>
</div>
