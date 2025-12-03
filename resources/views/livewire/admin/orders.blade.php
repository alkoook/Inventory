<<<<<<< HEAD
<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">
                Order Requests
            </h1>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-400 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden">
            @if($carts->isEmpty())
                <div class="p-6 text-center text-gray-400">
                    No pending order requests.
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700/50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Submitted At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Amount</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($carts as $cart)
                            <tr class="hover:bg-gray-700/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $cart->user->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $cart->submitted_at ? $cart->submitted_at->format('M d, Y H:i') : '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400 font-bold">${{ number_format($cart->total_amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="viewDetails({{ $cart->id }})" class="text-purple-400 hover:text-purple-300">View Details</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t border-gray-700">
                    {{ $carts->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen && $selectedCart)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-700">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-white mb-4" id="modal-title">
                            Order Details - {{ $selectedCart->user->name ?? 'Guest' }}
                        </h3>
                        
                        <div class="mb-4 text-gray-300 text-sm">
                            <p><strong>Submitted:</strong> {{ $selectedCart->submitted_at ? $selectedCart->submitted_at->format('M d, Y H:i') : '-' }}</p>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-700">
                                <thead class="bg-gray-700/30">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase">Product</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-300 uppercase">Qty</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-300 uppercase">Price</th>
                                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-300 uppercase">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @foreach($selectedCart->items as $item)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-white">{{ $item->product->name ?? 'Unknown Product' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-300 text-right">{{ $item->quantity }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-300 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-4 py-2 text-sm text-white text-right">${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-700/30">
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-right font-bold text-white">Grand Total:</td>
                                        <td class="px-4 py-2 text-right font-bold text-green-400">${{ number_format($selectedCart->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                        <button wire:click="approve({{ $selectedCart->id }})" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:w-auto sm:text-sm">
                            Approve & Create Order
                        </button>
                        <button wire:click="reject({{ $selectedCart->id }})" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                            Reject
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
=======
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
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    @endif
</div>
