<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(239, 68, 68, 0.03) 100%);">
            <input wire:model.live="search" type="text" placeholder="بحث..." class="w-full sm:w-64 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 text-sm rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            <a href="{{ route('admin.products.create') }}" class="w-full sm:w-auto text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 font-medium rounded-xl text-sm px-5 py-2.5 transition-all shadow-lg" style="box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">إضافة منتج</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-300">
                <thead class="bg-slate-800/50 border-b border-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الاسم</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">SKU</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الصنف</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">المخزون</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">السعر</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-100">{{ $product->name }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->sku }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $product->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-xs font-medium {{ $product->stock > $product->reorder_level ? 'bg-green-500/20 text-green-400 border border-green-500/50' : 'bg-red-500/20 text-red-400 border border-red-500/50' }}" style="{{ $product->stock > $product->reorder_level ? 'box-shadow: 0 0 10px rgba(34, 197, 94, 0.2);' : 'box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-100">${{ number_format($product->sale_price, 2) }}</td>
                            <td class="px-6 py-4 flex gap-3">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">تعديل</a>
                                <button wire:click="delete({{ $product->id }})" wire:confirm="هل أنت متأكد؟" class="text-red-400 hover:text-red-300 transition-colors">حذف</button>
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
