<div>
    <div class="max-w-3xl mx-auto bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <h2 class="text-2xl font-bold mb-6 text-gray-100">فاتورة مشتريات #{{ $invoice->invoice_number }}</h2>
        
        <div class="mb-6 grid grid-cols-2 gap-4 text-sm text-gray-300">
            <div><strong class="text-gray-400">الشركة:</strong> {{ $invoice->company->name ?? '—' }}</div>
            <div><strong class="text-gray-400">التاريخ:</strong> {{ $invoice->invoice_date }}</div>
            @if($invoice->notes)
                <div class="col-span-2"><strong class="text-gray-400">ملاحظات:</strong> {{ $invoice->notes }}</div>
            @endif
        </div>

        <table class="w-full mb-6 text-sm text-gray-300">
            <thead class="bg-slate-800/50 border-b border-slate-700/50">
                <tr>
                    <th class="px-4 py-2 text-right text-gray-400 font-semibold">المنتج</th>
                    <th class="px-4 py-2 text-right text-gray-400 font-semibold">الكمية</th>
                    <th class="px-4 py-2 text-right text-gray-400 font-semibold">وحدة القياس</th>
                    <th class="px-4 py-2 text-right text-gray-400 font-semibold">السعر</th>
                    <th class="px-4 py-2 text-right text-gray-400 font-semibold">المجموع</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                @foreach($invoice->items as $item)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-4 py-2 text-gray-100">{{ $item->product->name }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $item->quantity }}</td>
                        <td class="px-4 py-2 text-gray-300">{{ $item->unit_of_measure ?? 'قطعة' }}</td>
                    <td class="px-4 py-2 text-gray-300">{{ number_format($item->unit_price, 2) }} {{ $invoice->currency ?? 'USD' }}</td>
                    <td class="px-4 py-2 font-semibold text-gray-100">{{ number_format($item->total_price, 2) }} {{ $invoice->currency ?? 'USD' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-800/50 font-bold border-t border-slate-700/50">
                <tr>
                    <td colspan="4" class="px-4 py-2 text-right text-gray-300">المجموع الكلي:</td>
                    <td class="px-4 py-2 text-right text-green-400">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency ?? 'USD' }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="flex justify-end">
            <a href="{{ route('admin.purchase-invoices.index') }}" class="bg-slate-700/50 hover:bg-slate-700 text-gray-300 px-5 py-2.5 rounded-xl transition-colors">رجوع</a>
        </div>
    </div>
</div>
