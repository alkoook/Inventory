<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <!-- Header with Search and Add Button -->
    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="flex-1 w-full sm:w-auto">
            <input 
                type="text" 
                wire:model.live="search" 
                placeholder="بحث برقم الفاتورة أو الزبون..."
                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
        </div>
        <button 
            wire:click="create"
            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            إنشاء فاتورة مبيعات
        </button>
    </div>

    <!-- Invoices Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">رقم الفاتورة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الزبون</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">التاريخ</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الإجمالي</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الحالة</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse ($invoices as $invoice)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                            {{ $invoice->invoice_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-700">
                            {{ $invoice->customer->name ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-slate-500">
                            {{ $invoice->invoice_date->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-blue-600">
                            {{ number_format($invoice->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $invoice->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex gap-2">
                                <button 
                                    wire:click="edit({{ $invoice->id }})"
                                    class="text-blue-600 hover:text-blue-900 transition"
                                >
                                    تعديل
                                </button>
                                <button 
                                    wire:click="delete({{ $invoice->id }})"
                                    wire:confirm="هل أنت متأكد من حذف هذه الفاتورة؟ سيتم استرجاع الكميات للمخزون."
                                    class="text-red-600 hover:text-red-900 transition"
                                >
                                    حذف
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            لا توجد فواتير مبيعات
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $invoices->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl relative max-h-[90vh] flex flex-col">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">
                    {{ $isEdit ? 'تعديل فاتورة مبيعات' : 'إنشاء فاتورة مبيعات جديدة' }}
                </h3>
                <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-6 overflow-y-auto flex-1">
                <form wire:submit.prevent="save" class="space-y-6">
                    <!-- Header Info -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">الزبون</label>
                            <select wire:model="customer_id" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">اختر الزبون</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">رقم الفاتورة</label>
                            <input type="text" wire:model="invoice_number" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('invoice_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">تاريخ الفاتورة</label>
                            <input type="date" wire:model="invoice_date" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('invoice_date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="border border-slate-200 rounded-lg overflow-hidden">
                        <table class="w-full text-right text-sm">
                            <thead class="bg-slate-50 text-slate-700 font-medium">
                                <tr>
                                    <th class="p-3 w-1/3">المنتج</th>
                                    <th class="p-3 w-24">الكمية</th>
                                    <th class="p-3 w-32">سعر الوحدة</th>
                                    <th class="p-3 w-32">الإجمالي</th>
                                    <th class="p-3 w-10"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 bg-white">
                                @foreach($items as $index => $item)
                                    <tr>
                                        <td class="p-2">
                                            <select wire:model.live="items.{{ $index }}.product_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <option value="">اختر المنتج</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} (متوفر: {{ $product->stock }})</option>
                                                @endforeach
                                            </select>
                                            @error("items.{$index}.product_id") <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                        </td>
                                        <td class="p-2">
                                            <input type="number" wire:model.live="items.{{ $index }}.quantity" min="1" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @error("items.{$index}.quantity") <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                        </td>
                                        <td class="p-2">
                                            <input type="number" step="0.01" wire:model.live="items.{{ $index }}.unit_price" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @error("items.{$index}.unit_price") <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                        </td>
                                        <td class="p-2 font-bold text-slate-900">
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
                        <div class="p-3 bg-slate-50 border-t border-slate-200">
                            <button type="button" wire:click="addItem" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                إضافة منتج آخر
                            </button>
                        </div>
                        @error('items') <div class="p-2 text-red-600 text-sm bg-red-50">{{ $message }}</div> @enderror
                    </div>

                    <!-- Totals -->
                    <div class="flex justify-end">
                        <div class="w-full md:w-1/3 bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-slate-900">المبلغ الإجمالي:</span>
                                <span class="text-blue-600">{{ number_format($total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                        <button 
                            type="button" 
                            wire:click="closeModal" 
                            class="px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-medium transition"
                        >
                            إلغاء
                        </button>
                        <button 
                            type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition"
                        >
                            {{ $isEdit ? 'تحديث الفاتورة' : 'حفظ الفاتورة' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
