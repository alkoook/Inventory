<div>
    <div class="max-w-3xl mx-auto bg-white rounded-2xl border p-6">
        <h2 class="text-2xl font-bold mb-6">فاتورة مبيعات #{{ $invoice->invoice_number }}</h2>
        
        <div class="mb-6 grid grid-cols-2 gap-4 text-sm">
            <div><strong>الزبون:</strong> {{ $invoice->customer->name }}</div>
            <div><strong>التاريخ:</strong> {{ $invoice->invoice_date }}</div>
            @if($invoice->notes)
                <div class="col-span-2"><strong>ملاحظات:</strong> {{ $invoice->notes }}</div>
            @endif
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
                @foreach($invoice->items as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->product->name }}</td>
                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                        <td class="px-4 py-2">${{ number_format($item->unit_price, 2) }}</td>
                        <td class="px-4 py-2 font-semibold">${{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50 font-bold">
                <tr>
                    <td colspan="3" class="px-4 py-2 text-right">المجموع الكلي:</td>
                    <td class="px-4 py-2 text-right text-green-600">${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="flex justify-end">
            <a href="{{ route('admin.sales-invoices.index') }}" class="bg-gray-100 px-5 py-2.5 rounded-xl">رجوع</a>
        </div>
    </div>
</div>
