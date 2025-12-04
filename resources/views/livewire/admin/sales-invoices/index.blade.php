<div>
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">{{ session('message') }}</div>
    @endif

    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <div class="p-6 border-b flex justify-between items-center">
            <input wire:model.live="search" type="text" placeholder="بحث عن فاتورة..." class="w-64 bg-gray-50 border rounded-xl p-2.5">
            <a href="{{ route('admin.sales-invoices.create') }}" class="text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl">إنشاء فاتورة</a>
        </div>

        <table class="w-full text-sm text-right">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4">رقم الفاتورة</th>
                    <th class="px-6 py-4">الزبون</th>
                    <th class="px-6 py-4">التاريخ</th>
                    <th class="px-6 py-4">المبلغ</th>
                    <th class="px-6 py-4">إجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-4">{{ $invoice->user->name ?? '—' }}</td>
                        <td class="px-6 py-4">{{ $invoice->invoice_date }}</td>
                        <td class="px-6 py-4 font-semibold text-green-600">${{ number_format($invoice->total_amount, 2) }}</td>
                        <td class="px-6 py-4 flex gap-3">
                            <a href="{{ route('admin.sales-invoices.view', $invoice->id) }}" class="text-blue-600">عرض</a>
                            <button wire:click="delete({{ $invoice->id }})" wire:confirm="سيتم استرجاع المخزون" class="text-red-600">حذف</button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px- py-8 text-center text-gray-500">لا توجد فواتير</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t">{{ $invoices->links() }}</div>
    </div>
</div>
