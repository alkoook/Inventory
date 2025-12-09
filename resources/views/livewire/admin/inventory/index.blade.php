<div>
    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-800">
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
                        <th class="px-6 py-4 text-gray-400 font-semibold">سعر الشراء</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">سعر البيع</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الصنف</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الشركة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-100">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->sku }}</td>
                            <td class="px-6 py-4 font-bold text-lg text-gray-100">{{ $product->stock }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ number_format($product->purchase_price, 2) }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ number_format($product->sale_price, 2) }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->company->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-400">لا توجد منتجات</td>
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
