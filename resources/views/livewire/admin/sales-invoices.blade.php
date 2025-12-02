<div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث برقم الفاتورة أو الزبون..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block p-2.5 pl-10">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                </div>
            </div>
            
            <button wire:click="create" class="w-full sm:w-auto text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-300 font-medium rounded-xl text-sm px-5 py-2.5 flex items-center justify-center gap-2 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                إنشاء فاتورة مبيعات
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">رقم الفاتورة</th>
                        <th scope="col" class="px-6 py-4 font-medium">الزبون</th>
                        <th scope="col" class="px-6 py-4 font-medium">التاريخ</th>
                        <th scope="col" class="px-6 py-4 font-medium">الإجمالي</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4">{{ $invoice->customer->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $invoice->id }})" class="font-medium text-cyan-600 hover:text-cyan-700 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $invoice->id }})" wire:confirm="هل أنت متأكد من حذف هذه الفاتورة؟ سيتم استرجاع الكميات للمخزون." class="font-medium text-red-600 hover:text-red-700 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                لا توجد فواتير مبيعات مضافة حالياً.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            {{ $invoices->links() }}
        </div>
    </div>

    <!-- Full Screen Modal for Invoice Form -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/50 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 w-full max-w-4xl relative max-h-[90vh] flex flex-col">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50 rounded-t-2xl">
                <h3 class="text-xl font-bold text-gray-900">
                    {{ $isEdit ? 'تعديل فاتورة مبيعات' : 'إنشاء فاتورة مبيعات جديدة' }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1">
                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- Header Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">الزبون</label>
                            <select wire:model="customer_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                                <option value="">اختر الزبون</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">رقم الفاتورة</label>
                            <input type="text" wire:model="invoice_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                            @error('invoice_number') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">تاريخ الفاتورة</label>
                            <input type="date" wire:model="invoice_date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                            @error('invoice_date') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="border border-gray-200 rounded-xl overflow-hidden">
                        <table class="w-full text-right text-sm">
                            <thead class="bg-gray-100 text-gray-700 font-medium">
                                <tr>
                                    <th class="p-3 w-1/3">المنتج</th>
                                    <th class="p-3 w-24">الكمية</th>
                                    <th class="p-3 w-32">سعر الوحدة</th>
                                    <th class="p-3 w-32">الإجمالي</th>
                                    <th class="p-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($items as $index => $item)
                                    <tr>
                                        <td class="p-2">
                                            <select wire:model.live="items.{{ $index }}.product_id" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2">
                                                <option value="">اختر المنتج</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} (متوفر: {{ $product->stock }})</option>
                                                @endforeach
                                            </select>
                                            @error("items.{$index}.product_id") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="p-2">
                                            <input type="number" wire:model.live="items.{{ $index }}.quantity" min="1" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2">
                                            @error("items.{$index}.quantity") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="p-2">
                                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.unit_price" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-2">
                                            @error("items.{$index}.unit_price") <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </td>
                                        <td class="p-2 font-bold text-gray-900">
                                            {{ number_format((float)$item['quantity'] * (float)$item['unit_price'], 2) }}
                                        </td>
                                        <td class="p-2 text-center">
                                            <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 hover:text-red-700">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-3 bg-gray-50 border-t border-gray-200">
                            <button type="button" wire:click="addItem" class="text-sm text-cyan-600 hover:text-cyan-700 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                إضافة منتج آخر
                            </button>
                        </div>
                        @error('items') <div class="p-2 text-red-500 text-xs">{{ $message }}</div> @enderror
                    </div>

                    <!-- Totals -->
                    <div class="flex justify-end">
                        <div class="w-full md:w-1/3 space-y-3 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-gray-900">المبلغ الإجمالي:</span>
                                <span class="text-emerald-600">{{ number_format($total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" wire:click="closeModal" class="text-gray-700 bg-gray-100 hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-xl text-sm px-6 py-3 text-center transition-colors">إلغاء</button>
                        <button type="submit" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-xl text-sm px-6 py-3 text-center transition-colors">
                            {{ $isEdit ? 'تحديث الفاتورة' : 'حفظ الفاتورة' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
