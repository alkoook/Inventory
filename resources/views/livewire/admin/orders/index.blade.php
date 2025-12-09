<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">{{ session('message') }}</div>
    @endif

    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <div class="p-6 border-b border-slate-700/50 flex justify-between items-center bg-slate-800">
            <h2 class="text-xl font-bold text-gray-100">الطلبات المعلقة</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-300">
                <thead class="bg-slate-800/50 border-b border-slate-700/50">
                    <tr>
                        <th class="px-6 py-4 text-gray-400 font-semibold">الزبون</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">التاريخ</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">المبلغ</th>
                        <th class="px-6 py-4 text-gray-400 font-semibold">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-100">{{ $order->user->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-400">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 font-semibold text-green-400">{{ number_format($order->total_amount, 0) }} ر.س</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.view', $order->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">عرض التفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">لا توجد طلبات معلقة</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-slate-700/50">{{ $orders->links() }}</div>
    </div>
</div>
