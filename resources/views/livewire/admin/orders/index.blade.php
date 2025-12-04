<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">{{ session('message') }}</div>
    @endif

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <h2 class="text-xl font-bold">الطلبات المعلقة</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-4">الزبون</th>
                        <th class="px-6 py-4">التاريخ</th>
                        <th class="px-6 py-4">المبلغ</th>
                        <th class="px-6 py-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $order->customer->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 font-semibold text-green-600">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.view', $order->id) }}" class="text-blue-600 hover:text-blue-700">عرض التفاصيل</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">لا توجد طلبات معلقة</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t">{{ $orders->links() }}</div>
    </div>
</div>
