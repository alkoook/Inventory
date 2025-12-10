<div class="max-w-4xl mx-auto bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl p-6" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">

    <h2 class="text-xl font-bold text-gray-100 mb-6">إنشاء فاتورة مشتريات</h2>

    <form wire:submit.prevent="save" class="space-y-6">

        <!-- Company + Date + Currency -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Company -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">الشركة</label>
                <select 
                    wire:model="company_id" 
                    class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                >
                    <option value="">بدون شركة</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                    @endforeach
                </select>
                @error('company_id')
                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">التاريخ *</label>
                <input 
                    wire:model="invoice_date" 
                    type="date" 
                    class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                >
                @error('invoice_date')
                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Currency -->
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-300">العملة *</label>
                <select 
                    wire:model="currency" 
                    class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                >
                    <option value="USD">دولار أمريكي (USD)</option>
                    <option value="SYP">ليرة سورية (SYP)</option>
                </select>
                @error('currency')
                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <!-- Items -->
        <div class="border border-slate-700/50 rounded-xl p-4 bg-slate-700/30">

            <h3 class="font-semibold mb-3 text-gray-200">الأصناف</h3>

            @foreach($items as $index => $item)
            <div class="flex flex-col md:flex-row items-start gap-3 mb-4 border-b pb-4 last:border-b-0 last:pb-0">

                <!-- Product input -->
                <div class="flex-1 w-full md:w-auto">
                    <label class="text-sm font-medium text-gray-300 mb-1 block">المنتج *</label>

                    <input 
                        placeholder="ابحث بالاسم أو SKU"
                        list="products_list"
                        wire:model.live.debounce.300ms="items.{{ $index }}.product_search"
                        class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    >

                    <!-- Hidden input to hold the actual product_id -->
                    <input type="hidden" wire:model="items.{{ $index }}.product_id">

                    @error("items.$index.product_id")
                        <span class="text-red-400 text-xs block mt-1">{{ $message }}</span>
                    @enderror

                    @error("items.$index.product_search")
                        <span class="text-red-400 text-xs block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Quantity -->
                <div class="w-28">
                    <label class="text-sm font-medium text-gray-300 mb-1 block">الكمية *</label>
                    <input 
                        wire:model.live="items.{{ $index }}.quantity"
                        type="number" min="1"
                        class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    >
                    @error("items.$index.quantity")
                        <span class="text-red-400 text-xs block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Unit of Measure -->
                <div class="w-32">
                    <label class="text-sm font-medium text-gray-300 mb-1 block">وحدة القياس *</label>
                    <select 
                        wire:model="items.{{ $index }}.unit_of_measure"
                        class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                    >
                        <option value="غرام">غرام</option>
                        <option value="كيلو">كيلو</option>
                        <option value="قطعة">قطعة</option>
                        <option value="علبة">علبة</option>
                        <option value="كيس">كيس</option>
                        <option value="ظرف">ظرف</option>
                        <option value="تنكة">تنكة</option>
                        <option value="طرد">طرد</option>
                    </select>
                    @error("items.$index.unit_of_measure")
                        <span class="text-red-400 text-xs block mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Old Sale Price (Display Only) -->
                @if($item['product_id'])
                    <div class="w-32">
                        <label class="text-sm font-medium text-gray-300 mb-1 block">سعر البيع القديم</label>
                        <input 
                            type="number" 
                            value="{{ number_format($item['old_sale_price'] ?? 0, 2) }}"
                            readonly
                            class="w-full bg-slate-700/30 border border-slate-600 text-gray-400 rounded-xl p-2.5 text-center cursor-not-allowed"
                        >
                    </div>
                @endif

                <!-- Unit Price (Purchase Price) -->
                <div class="w-32">
                    <label class="text-sm font-medium text-gray-300 mb-1 block">سعر الشراء *</label>
                    <input 
                        wire:model.live="items.{{ $index }}.unit_price"
                        type="number" min="0" step="0.01"
                        class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5 text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        x-on:keydown.tab.prevent="$wire.addItem()"
                    >
                    @error("items.$index.unit_price")
                        <span class="text-red-400 text-xs block mt-1">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Subtotal -->
                @php
                    $subtotal = ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
                @endphp
                <div class="w-24 mt-4 text-center">
                    <p class="text-sm font-medium text-gray-300 mb-1">الإجمالي</p>
                    <p class="font-bold text-gray-100">{{ number_format($subtotal, 2) }}</p>
                </div>

                <!-- Remove -->
                <div class="mt-4 md:mt-6">
                    <button 
                        type="button" 
                        wire:click="removeItem({{ $index }})"
                        class="text-red-400 font-bold text-xl px-2 hover:text-red-300 transition duration-150"
                        title="حذف الصنف"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
            @endforeach

            <button 
                type="button"
                wire:click="addItem"
                class="text-blue-400 hover:text-blue-300 text-sm font-medium hover:underline flex items-center gap-1 mt-3 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                إضافة صنف
            </button>

        </div>

        <!-- Products list (datalist definition) -->
        <datalist id="products_list">
            {{-- Products are loaded in the mount() method --}}
            @foreach($products as $product)
                <option 
                    value="{{ $product->name }} — {{ $product->sku }}" 
                    data-id="{{ $product->id }}"
                ></option>
            @endforeach
        </datalist>
        
        <!-- Invoice Total -->
        <div class="flex justify-end pt-4">
            <div class="w-64 p-4 border border-blue-500/50 rounded-xl bg-slate-700/50 text-right">
                <p class="text-lg font-medium text-gray-200">إجمالي الفاتورة:</p>
                <p class="text-3xl font-extrabold text-blue-400">{{ number_format($total_amount, 2) }} <span class="text-xl">{{ $currency === 'USD' ? 'USD' : 'SYP' }}</span></p>
            </div>
        </div>

        <!-- Notes -->
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-300">ملاحظات</label>
            <textarea 
                wire:model="notes"
                rows="2"
                class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 placeholder-gray-400 rounded-xl p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            ></textarea>
        </div>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4 border-t border-slate-700/50">
            <a 
                href="{{ route('admin.purchase-invoices.index') }}"
                class="bg-slate-700/50 hover:bg-slate-700 px-5 py-2.5 rounded-xl text-gray-300 transition duration-150"
            >
                إلغاء
            </a>

            <button 
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl transition duration-150 font-semibold shadow-lg"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove wire:target="save">حفظ الفاتورة</span>
                <span wire:loading wire:target="save">جاري الحفظ...</span>
            </button>
        </div>

    </form>
</div>
