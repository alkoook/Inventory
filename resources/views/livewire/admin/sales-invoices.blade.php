<<<<<<< HEAD
<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">
                Sales Invoices
            </h1>
            <button wire:click="create" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform transition hover:scale-105">
                Create Invoice
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search invoices..." class="w-full md:w-1/3 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
        </div>

        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Invoice #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($invoices as $invoice)
                        <tr class="hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $invoice->customer->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') : '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400 font-bold">${{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="view({{ $invoice->id }})" class="text-purple-400 hover:text-purple-300 mr-3">View</button>
                                <button wire:click="delete({{ $invoice->id }})" class="text-red-400 hover:text-red-300" onclick="return confirm('Are you sure?')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4 border-t border-gray-700">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    @if($isOpen)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-gray-700">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-white mb-4" id="modal-title">
                            Create Sales Invoice
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Customer</label>
                                <select wire:model="customer_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500">
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Date</label>
                                <input wire:model="invoice_date" type="date" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500">
                                @error('invoice_date') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Items</label>
                            <div class="space-y-2">
                                @foreach($items as $index => $item)
                                    <div class="flex gap-2 items-start">
                                        <div class="flex-1">
                                            <select wire:model.live="items.{{ $index }}.product_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500 text-sm">
                                                <option value="">Select Product</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                                                @endforeach
                                            </select>
                                            @error('items.'.$index.'.product_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-24">
                                            <input wire:model="items.{{ $index }}.quantity" type="number" placeholder="Qty" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500 text-sm">
                                            @error('items.'.$index.'.quantity') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="w-32">
                                            <input wire:model="items.{{ $index }}.unit_price" type="number" step="0.01" placeholder="Price" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500 text-sm">
                                            @error('items.'.$index.'.unit_price') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <button wire:click="removeItem({{ $index }})" class="text-red-400 hover:text-red-300 p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            <button wire:click="addItem" class="mt-2 text-sm text-purple-400 hover:text-purple-300 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add Item
                            </button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Notes</label>
                            <textarea wire:model="notes" rows="2" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500"></textarea>
                        </div>
                    </div>
                    <div class="bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Create Invoice
                        </button>
                        <button wire:click="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- View Modal -->
    @if($viewOpen && $selectedInvoice)
        <div class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-700">
                    <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                                Invoice {{ $selectedInvoice->invoice_number }}
                            </h3>
                            <span class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($selectedInvoice->invoice_date)->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="mb-4 text-gray-300 text-sm">
                            <p><strong>Customer:</strong> {{ $selectedInvoice->customer->name ?? 'N/A' }}</p>
                            @if($selectedInvoice->notes)
                                <p class="mt-2"><strong>Notes:</strong> {{ $selectedInvoice->notes }}</p>
                            @endif
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
                                    @foreach($selectedInvoice->items as $item)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-white">{{ $item->product->name ?? 'Unknown' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-300 text-right">{{ $item->quantity }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-300 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                            <td class="px-4 py-2 text-sm text-white text-right">${{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-700/30">
                                    <tr>
                                        <td colspan="3" class="px-4 py-2 text-right font-bold text-white">Grand Total:</td>
                                        <td class="px-4 py-2 text-right font-bold text-green-400">${{ number_format($selectedInvoice->total_amount, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeModal" type="button" class="w-full inline-flex justify-center rounded-md border border-gray-600 shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-gray-300 hover:bg-gray-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
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
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    @endif
</div>
