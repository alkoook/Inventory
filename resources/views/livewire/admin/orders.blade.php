<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Header with Search -->
    <div class="mb-6">
        <div class="w-full sm:w-64">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="بحث برقم الطلب أو اسم الزبون..."
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">رقم الطلب</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الزبون</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">التاريخ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">عدد العناصر</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الإجمالي</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">إجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ $order->customer->name ?? 'زائر' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">{{ $order->items->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-600">{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'submitted' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'submitted' => 'بانتظار الموافقة',
                                    'approved' => 'تمت الموافقة',
                                    'rejected' => 'مرفوض',
                                ];
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button 
                                wire:click="viewOrder({{ $order->id }})"
                                class="text-blue-600 hover:text-blue-900 transition"
                            >
                                عرض التفاصيل
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                            لا توجد طلبات حالياً.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <!-- Order Details Modal -->
    @if($showModal && $selectedOrder)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl relative">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">
                    تفاصيل الطلب #{{ $selectedOrder->id }}
                </h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">الزبون</p>
                        <p class="font-medium text-slate-900">{{ $selectedOrder->customer->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">تاريخ الطلب</p>
                        <p class="font-medium text-slate-900">{{ $selectedOrder->created_at->format('Y-m-d H:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 mb-1">الحالة</p>
                        <p class="font-medium text-slate-900">
                            {{ $statusLabels[$selectedOrder->status] ?? $selectedOrder->status }}
                        </p>
                    </div>
                </div>

                <div class="border border-slate-200 rounded-lg overflow-hidden mb-6">
                    <table class="w-full text-right text-sm">
                        <thead class="bg-slate-50 text-slate-700 font-medium">
                            <tr>
                                <th class="p-3">المنتج</th>
                                <th class="p-3">الكمية</th>
                                <th class="p-3">السعر</th>
                                <th class="p-3">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @foreach($selectedOrder->items as $item)
                                <tr>
                                    <td class="p-3 text-slate-900">{{ $item->product->name ?? 'منتج محذوف' }}</td>
                                    <td class="p-3 text-slate-700">{{ $item->quantity }}</td>
                                    <td class="p-3 text-slate-700">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="p-3 font-bold text-slate-900">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-slate-50 font-bold text-slate-900">
                            <tr>
                                <td colspan="3" class="p-3 text-left">المجموع الكلي:</td>
                                <td class="p-3 text-blue-600">{{ number_format($selectedOrder->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($selectedOrder->status === 'submitted')
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                        <button 
                            wire:click="rejectOrder" 
                            wire:confirm="هل أنت متأكد من رفض هذا الطلب؟ سيتم حذفه نهائياً." 
                            class="px-4 py-2 bg-red-50 text-red-700 hover:bg-red-100 rounded-lg font-medium transition"
                        >
                            رفض الطلب
                        </button>
                        <button 
                            wire:click="approveOrder" 
                            wire:confirm="هل أنت متأكد من الموافقة على هذا الطلب؟ سيتم إنشاء فاتورة وخصم المخزون." 
                            class="px-4 py-2 bg-green-600 text-white hover:bg-green-700 rounded-lg font-medium transition"
                        >
                            موافقة واعتماد
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
