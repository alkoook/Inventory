<div>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-2xl border shadow-sm p-6">
            <h2 class="text-xl font-bold mb-6">تفاصيل الطلب - {{ $order->customer->name }}</h2>
            
            <div class="mb-6">
                <p class="text-sm text-gray-600"><strong>التاريخ:</strong> {{ $order->created_at->format ('Y-m-d H:i') }}</p>
                <p class="text-sm text-gray-600"><strong>الحالة:</strong> 
                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">{{ $order->status }}</span>
                </p>
            </div>

            <table class="w-full mb-6 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-right">المنتج</th>
                        <th class="px-4 py-2 text-right">الكمية</th>
                        <th class="px-4 py-2 text-right">السعر</th>
                        <th class="px-4 py-2 text-right">المجموع</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->product->name }}</td>
                            <td class="px-4 py-2">{{ $item->quantity }}</td>
                            <td class="px-4 py-2">${{ number_format($item->unit_price, 2) }}</td>
                            <td class="px-4 py-2 font-semibold">${{ number_format($item->total_price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-right font-bold">المجموع الكلي:</td>
                        <td class="px-4 py-2 font-bold text-green-600">${{ number_format($order->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>

            <div class="flex justify-end gap-3 pt-4 border-t">
                @if($order->status == 'pending')
                    <button wire:click="approveOrder" wire:confirm="سيتم إنشاء فاتورة مبيعات و تحديث المخزون" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl">موافقة</button>
                    <button wire:click="rejectOrder" wire:confirm="هل أنت متأكد؟" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-xl">رفض</button>
                @endif
                <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 hover:bg-gray-200 px-5 py-2.5 rounded-xl">رجوع</a>
            </div>
        </div>
    </div>
</div>
