<<<<<<< HEAD
<div class="min-h-screen bg-gray-900 text-white p-6">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">
                Purchase Invoices
            </h1>
            <button wire:click="create" class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-bold py-2 px-4 rounded-lg shadow-lg transform transition hover:scale-105">
                Create Purchase
            </button>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-500/10 border border-green-500 text-green-400 px-4 py-3 rounded mb-6 relative" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search purchases..." class="w-full md:w-1/3 bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-white focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500 transition-colors">
        </div>

        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Invoice #</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Company</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($invoices as $invoice)
                        <tr class="hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $invoice->company->name ?? 'N/A' }}</td>
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
                            Create Purchase Invoice
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Company</label>
                                <select wire:model="company_id" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-purple-500">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                @error('company_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
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
=======
<div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="relative w-full sm:w-64">
                <input wire:model.live="search" type="text" placeholder="بحث برقم الفاتورة أو الشركة..." class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block p-2.5 pl-10">
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
                إنشاء فاتورة شراء
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-medium">رقم الفاتورة</th>
                        <th scope="col" class="px-6 py-4 font-medium">الشركة</th>
                        <th scope="col" class="px-6 py-4 font-medium">التاريخ</th>
                        <th scope="col" class="px-6 py-4 font-medium">الإجمالي</th>
                        <th scope="col" class="px-6 py-4 font-medium">المدفوع</th>
                        <th scope="col" class="px-6 py-4 font-medium">المتبقي</th>
                        <th scope="col" class="px-6 py-4 font-medium">الحالة</th>
                        <th scope="col" class="px-6 py-4 font-medium">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4">{{ $invoice->company->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $invoice->invoice_date->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 font-bold text-gray-900">{{ number_format($invoice->total_amount, 2) }}</td>
                            <td class="px-6 py-4 text-emerald-600">{{ number_format($invoice->paid_amount, 2) }}</td>
                            <td class="px-6 py-4 text-red-600">{{ number_format($invoice->remaining_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-600">
                                    {{ $invoice->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-3">
                                <button wire:click="edit({{ $invoice->id }})" class="font-medium text-cyan-600 hover:text-cyan-700 transition-colors">تعديل</button>
                                <button wire:click="delete({{ $invoice->id }})" wire:confirm="هل أنت متأكد من حذف هذه الفاتورة؟ سيتم خصم الكميات من المخزون." class="font-medium text-red-600 hover:text-red-700 transition-colors">حذف</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                لا توجد فواتير شراء مضافة حالياً.
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
                    {{ $isEdit ? 'تعديل فاتورة شراء' : 'إنشاء فاتورة شراء جديدة' }}
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
                            <label class="block mb-2 text-sm font-medium text-gray-700">الشركة الموردة</label>
                            <select wire:model="company_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-cyan-500 focus:border-cyan-500 block w-full p-2.5">
                                <option value="">اختر الشركة</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
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
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
<<<<<<< HEAD
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
                            Create Purchase
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
                                Purchase {{ $selectedInvoice->invoice_number }}
                            </h3>
                            <span class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($selectedInvoice->invoice_date)->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="mb-4 text-gray-300 text-sm">
                            <p><strong>Company:</strong> {{ $selectedInvoice->company->name ?? 'N/A' }}</p>
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
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">المبلغ الإجمالي:</span>
                                <span class="font-bold text-gray-900">{{ number_format($total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">المدفوع:</span>
                                <input type="number" step="0.01" wire:model.live="paid_amount" class="w-32 bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-cyan-500 focus:border-cyan-500 p-1 text-right">
                            </div>
                            <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2">
                                <span class="text-gray-900">المتبقي:</span>
                                <span class="{{ $remaining_amount > 0 ? 'text-red-600' : 'text-emerald-600' }}">{{ number_format($remaining_amount, 2) }}</span>
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
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    @endif
</div>
