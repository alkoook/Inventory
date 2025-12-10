<div>
    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-xl font-bold mb-6 text-gray-100">تفاصيل الطلب</h2>
            
            @if (session()->has('message'))
                <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl">{{ session('message') }}</div>
            @endif

            <div class="mb-6 space-y-2">
                <p class="text-sm text-gray-400"><strong class="text-gray-300">الزبون:</strong> {{ $cart->user->name ?? '-' }}</p>
                <p class="text-sm text-gray-400"><strong class="text-gray-300">البريد:</strong> {{ $cart->user->email ?? '-' }}</p>
                <p class="text-sm text-gray-400"><strong class="text-gray-300">التاريخ:</strong> {{ $cart->submitted_at?->format('Y-m-d H:i') ?? $cart->created_at->format('Y-m-d H:i') }}</p>
                <p class="text-sm text-gray-400"><strong class="text-gray-300">الحالة:</strong> 
                    <span class="px-2 py-1 rounded text-xs bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">معلق</span>
                </p>
                <div class="text-sm text-gray-400">
                    <strong class="text-gray-300">العامل المسند:</strong> 
                    @if($cart->worker)
                        <span class="text-blue-400">{{ $cart->worker->name }}</span>
                    @else
                        <span class="text-gray-500">غير مسند</span>
                    @endif
                </div>
            </div>

            @if($cart->status == 'submitted')
            <div class="mb-6 p-4 bg-slate-700/30 rounded-xl border border-slate-600">
                <label class="block text-sm font-semibold text-gray-300 mb-2">إسناد عامل:</label>
                <div class="flex gap-3 items-end">
                    <select wire:model="workerId" class="flex-1 bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">اختر عامل</option>
                        @foreach($workers as $worker)
                            <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                        @endforeach
                    </select>
                    <button wire:click="assignWorker" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-medium transition-all">
                        إسناد
                    </button>
                </div>
            </div>
            @endif

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
                                <td class="px-4 py-3">{{ number_format($item->unit_price, 0) }} USD</td>
                                <td class="px-4 py-3 font-semibold text-blue-400">{{ number_format($item->total_price, 0) }} USD</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-slate-700/50 border-t border-slate-600">
                        <tr>
                            <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-200">المجموع الكلي:</td>
                            <td class="px-4 py-3 font-bold text-green-400 text-lg">{{ number_format($cart->total_amount, 0) }} USD</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($cart->status == 'submitted')
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
                    <a href="{{ route('admin.orders.approve', $cart->id) }}" 
                       wire:navigate
                       class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">
                        موافقة
                    </a>
                    <a href="{{ route('admin.orders.reject', $cart->id) }}" 
                       wire:navigate
                       class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-medium transition-all shadow-lg hover:shadow-xl">
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
