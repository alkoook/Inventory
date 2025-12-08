<div>
    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-xl font-bold mb-6 text-gray-100">تفاصيل الطلب</h2>
            
            <div class="mb-6 space-y-2">
                <p class="text-sm text-gray-400"><strong class="text-gray-300">الزبون:</strong> {{ $cart->user->name ?? '-' }}</p>
                <p class="text-sm text-gray-400"><strong class="text-gray-300">البريد:</strong> {{ $cart->user->email ?? '-' }}</p>
                <p class="text-sm text-gray-400"><strong class="text-gray-300">التاريخ:</strong> {{ $cart->submitted_at?->format('Y-m-d H:i') ?? $cart->created_at->format('Y-m-d H:i') }}</p>
                <p class="text-sm text-gray-400"><strong class="text-gray-300">الحالة:</strong> 
                    <span class="px-2 py-1 rounded text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">معلق</span>
                </p>
            </div>

            <div class="mb-6 overflow-x-auto">
                <table class="w-full text-sm text-gray-300">
                    <thead class="bg-slate-700/50 border-b border-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-right text-gray-400">المنتج</th>
                            <th class="px-4 py-3 text-right text-gray-400">الصنف</th>
                            <th class="px-4 py-3 text-right text-gray-400">الكمية</th>
                            <th class="px-4 py-3 text-right text-gray-400">السعر</th>
                            <th class="px-4 py-3 text-right text-gray-400">المجموع</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($cart->items as $item)
                            <tr class="hover:bg-slate-700/30">
                                <td class="px-4 py-3 text-gray-100">{{ $item->product->name }}</td>
                                <td class="px-4 py-3 text-gray-400">{{ $item->product->category->name ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">{{ number_format($item->unit_price, 0) }} ر.س</td>
                                <td class="px-4 py-3 font-semibold text-blue-400">{{ number_format($item->total_price, 0) }} ر.س</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-700/50 border-t border-slate-600">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-200">المجموع الكلي:</td>
                            <td class="px-4 py-3 font-bold text-green-400 text-lg">{{ number_format($cart->total_amount, 0) }} ر.س</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($cart->status == 'submitted')
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <a href="{{ route('admin.orders.approve', $cart->id) }}" 
                       wire:navigate
                       class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">
                        موافقة
                    </a>
                    <a href="{{ route('admin.orders.reject', $cart->id) }}" 
                       wire:navigate
                       class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">
                        رفض
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="bg-slate-700 hover:bg-slate-600 text-gray-100 px-6 py-3 rounded-xl font-medium transition-all">
                        رجوع
                    </a>
                </div>
            @else
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="bg-slate-700 hover:bg-slate-600 text-gray-100 px-6 py-3 rounded-xl font-medium transition-all">
                        رجوع
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
