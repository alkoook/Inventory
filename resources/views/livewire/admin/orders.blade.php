<div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث برقم الطلب أو اسم الزبون..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">رقم الطلب</th>
                        <th scope="col" class="px-6 py-4 font-medium">الزبون</th>
                        <th scope="col" class="px-6 py-4 font-medium">التاريخ</th>
                        <th scope="col" class="px-6 py-4 font-medium">عدد العناصر</th>
                        <th scope="col" class="px-6 py-4 font-medium">الإجمالي</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4">{{ $order->customer->name ?? 'زائر' }}</td>
                            <td class="px-6 py-4">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4">{{ $order->items->count() }}</td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'submitted' => 'bg-yellow-50 text-yellow-600',
                                        'approved' => 'bg-emerald-50 text-emerald-600',
                                        'rejected' => 'bg-red-50 text-red-600',
                                    ];
                                    $statusLabels = [
                                        'submitted' => 'بانتظار الموافقة',
                                        'approved' => 'تمت الموافقة',
                                        'rejected' => 'مرفوض',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="viewOrder({{ $order->id }})" class="font-medium text-cyan-600 hover:text-cyan-700 transition-colors">عرض التفاصيل</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                لا توجد طلبات حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    </div>

    <!-- Order Details Modal -->
    @if($showModal && $selectedOrder)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-2xl relative">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">
                    تفاصيل الطلب #{{ $selectedOrder->id }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500">الزبون</p>
                        <p class="font-medium text-gray-900">{{ $selectedOrder->customer->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">تاريخ الطلب</p>
                        <p class="font-medium text-gray-900">{{ $selectedOrder->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">الحالة</p>
                        <p class="font-medium text-gray-900">{{ $selectedOrder->status }}</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-xl overflow-hidden mb-6">
                    <table class="w-full text-right text-sm">
                        <thead class="bg-gray-100 text-gray-700 font-medium">
                            <tr>
                                <th class="p-3">المنتج</th>
                                <th class="p-3">الكمية</th>
                                <th class="p-3">السعر</th>
                                <th class="p-3">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($selectedOrder->items as $item)
                                <tr>
                                    <td class="p-3">{{ $item->product->name ?? 'منتج محذوف' }}</td>
                                    <td class="p-3">{{ $item->quantity }}</td>
                                    <td class="p-3">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="p-3 font-bold">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-bold text-gray-900">
                            <tr>
                                <td colspan="3" class="p-3 text-left">المجموع الكلي:</td>
                                <td class="p-3">{{ number_format($selectedOrder->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($selectedOrder->status === 'submitted')
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button wire:click="rejectOrder" wire:confirm="هل أنت متأكد من رفض هذا الطلب؟ سيتم حذفه نهائياً." class="text-red-600 bg-red-50 hover:bg-red-100 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">
                            رفض الطلب
                        </button>
                        <button wire:click="approveOrder" wire:confirm="هل أنت متأكد من الموافقة على هذا الطلب؟ سيتم إنشاء فاتورة وخصم المخزون." class="text-white bg-emerald-600 hover:bg-emerald-700 focus:ring-4 focus:outline-none focus:ring-emerald-300 font-medium rounded-xl text-sm px-5 py-2.5 text-center transition-colors">
                            موافقة واعتماد
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
