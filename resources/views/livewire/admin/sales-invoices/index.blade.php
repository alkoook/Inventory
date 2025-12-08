<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.2);">{{ session('message') }}</div>
    @endif

    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
        <div class="p-6 border-b border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(239, 68, 68, 0.03) 100%);">
            <input wire:model.live="search" type="text" placeholder="بحث عن فاتورة..." class="w-full sm:w-64 bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
            <a href="{{ route('admin.sales-invoices.create') }}" class="w-full sm:w-auto text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 px-5 py-2.5 rounded-xl transition-all shadow-lg" style="box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);">إنشاء فاتورة</a>
        </div>

        <table class="w-full text-sm text-right text-gray-300">
            <thead class="bg-slate-800/50 border-b border-slate-700/50">
                <tr>
                    <th class="px-6 py-4 text-gray-400 font-semibold">رقم الفاتورة</th>
                    <th class="px-6 py-4 text-gray-400 font-semibold">الزبون</th>
                    <th class="px-6 py-4 text-gray-400 font-semibold">التاريخ</th>
                    <th class="px-6 py-4 text-gray-400 font-semibold">المبلغ</th>
                    <th class="px-6 py-4 text-gray-400 font-semibold">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-700/50">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-100">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $invoice->user->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-400">{{ $invoice->invoice_date }}</td>
                        <td class="px-6 py-4 font-semibold text-green-400">${{ number_format($invoice->total_amount, 2) }}</td>
                        <td class="px-6 py-4 flex gap-3">
                            <a href="{{ route('admin.sales-invoices.view', $invoice->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">عرض</a>
                            <button wire:click="delete({{ $invoice->id }})" wire:confirm="سيتم استرجاع المخزون" class="text-red-400 hover:text-red-300 transition-colors">حذف</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">لا توجد فواتير</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-slate-700/50">{{ $invoices->links() }}</div>
    </div>
</div>
