<div>
    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4 bg-slate-800">
            <input wire:model.live="search" type="text" placeholder="بحث عن فاتورة..." class="w-full sm:w-64 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
        </div>

        <table class="w-full text-sm text-right text-gray-300">
            <thead class="bg-slate-800/50 border-b border-slate-700/50">
                <tr>
                    <th class="px-6 py-4 text-gray-400 font-semibold">رقم الفاتورة</th>
                    <th class="px-6 py-4 text-gray-400 font-semibold">الزبون</th>
                    <th class="px-6 py-4 text-gray-400 font-semibold">التاريخ</th>
                    {{--  <th class="px-6 py-4 text-gray-400 font-semibold">المبلغ</th>  --}}
                    <th class="px-6 py-4 text-gray-400 font-semibold">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-100">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $invoice->customer->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                        {{--  <td class="px-6 py-4 font-semibold text-green-400">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency ?? 'USD' }}</td>  --}}
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.workers.invoice-view', $invoice->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">عرض</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">لا توجد فواتير مسندة لك</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-700/50">{{ $invoices->links() }}</div>
    </div>
</div>
