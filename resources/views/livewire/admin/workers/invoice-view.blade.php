<div>
    <div class="max-w-3xl mx-auto">
        <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6">
            <h2 class="text-2xl font-bold mb-6 text-gray-100">فاتورة #{{ $invoice->invoice_number }}</h2>
            
            <!-- معلومات الزبون -->
            <div class="mb-6 p-4 bg-slate-700/30 rounded-xl border border-slate-600">
                <h3 class="text-lg font-semibold text-gray-200 mb-3">معلومات الزبون</h3>
                <p class="text-gray-300">{{ $invoice->customer->name ?? '—' }}</p>
            </div>

            <!-- المنتجات -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-200 mb-4">المنتجات</h3>
                <table class="w-full text-sm text-gray-300">
                    <thead class="bg-slate-700/50 border-b border-slate-600">
                        <tr>
                            <th class="px-4 py-3 text-right text-gray-400 font-semibold">المنتج</th>
                            <th class="px-4 py-3 text-right text-gray-400 font-semibold">الكمية</th>
                            <th class="px-4 py-3 text-right text-gray-400 font-semibold">وحدة القياس</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @foreach($invoice->items as $item)
                            <tr class="hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3 text-gray-100">{{ $item->product->name }}</td>
                                <td class="px-4 py-3 text-gray-300">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-gray-300">{{ $item->unit_of_measure ?? 'قطعة' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('admin.workers.my-invoices') }}" 
                   class="bg-slate-700 hover:bg-slate-600 text-gray-100 px-6 py-3 rounded-xl font-medium transition-all">
                    رجوع
                </a>
            </div>
        </div>
    </div>
</div>
