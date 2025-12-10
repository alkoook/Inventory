<div>
    <div class="bg-slate-800 rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
        <!-- Report Tabs -->
        <div class="p-6 border-b border-slate-700/50 bg-slate-800">
            <div class="flex flex-wrap gap-2 mb-4">
                <button wire:click="$set('activeReport', 'inventory')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'inventory' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    جرد المخزون
                </button>
                <button wire:click="$set('activeReport', 'low_stock')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'low_stock' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    منخفضة المخزون
                </button>
                <button wire:click="$set('activeReport', 'movement')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'movement' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    حركة المخزون
                </button>
                <button wire:click="$set('activeReport', 'sales_by_product')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'sales_by_product' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    المبيعات حسب المنتج
                </button>
                <button wire:click="$set('activeReport', 'sales_by_period')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'sales_by_period' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    المبيعات حسب الفترة
                </button>
                <button wire:click="$set('activeReport', 'slow_moving')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'slow_moving' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    الأصناف الراكدة
                </button>
                <button wire:click="$set('activeReport', 'profit_loss')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'profit_loss' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    الأرباح والخسائر
                </button>
                <button wire:click="$set('activeReport', 'customer_sales')" 
                        class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $activeReport === 'customer_sales' ? 'bg-blue-600 text-white' : 'bg-slate-700/50 text-gray-300 hover:bg-slate-700' }}">
                    المبيعات حسب العملاء
                </button>
            </div>

            <!-- Filters -->
            @if(in_array($activeReport, ['movement', 'sales_by_product', 'sales_by_period', 'profit_loss', 'customer_sales']))
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">من تاريخ</label>
                    <input type="date" wire:model.live="dateFrom" 
                           class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">إلى تاريخ</label>
                    <input type="date" wire:model.live="dateTo" 
                           class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5">
                </div>
                @if(in_array($activeReport, ['movement']))
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">المنتج</label>
                    <select wire:model.live="productId" 
                            class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5">
                        <option value="">كل المنتجات</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                @if($activeReport === 'customer_sales')
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-300">العميل</label>
                    <select wire:model.live="customerId" 
                            class="w-full bg-slate-700/50 border border-slate-600 text-gray-100 rounded-xl p-2.5">
                        <option value="">كل العملاء</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Report Content -->
        <div class="p-6">
            @if($activeReport === 'inventory')
                <!-- Inventory Report -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-300">
                        <thead class="bg-slate-700/50 border-b border-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المنتج</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">SKU</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الصنف</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الكمية الحالية</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الحد الأدنى</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">سعر الشراء</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">التكلفة الإجمالية</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($inventoryProducts ?? [] as $product)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-100">{{ $product['name'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['sku'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['category'] ?? '-' }}</td>
                                    <td class="px-4 py-3 {{ $product['current_stock'] <= $product['reorder_level'] ? 'text-red-400 font-bold' : 'text-gray-300' }}">
                                        {{ $product['current_stock'] }} {{ $product['unit_of_measure'] }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['reorder_level'] }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ number_format($product['purchase_price'], 2) }} USD</td>
                                    <td class="px-4 py-3 font-semibold text-green-400">{{ number_format($product['total_cost'], 2) }} USD</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">لا توجد منتجات</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if(isset($inventoryProducts) && $inventoryProducts->count() > 0)
                        <tfoot class="bg-slate-700/50">
                            <tr>
                                <td colspan="6" class="px-4 py-3 text-right font-bold text-gray-200">إجمالي تكلفة المخزون:</td>
                                <td class="px-4 py-3 font-bold text-green-400">
                                    {{ number_format(collect($inventoryProducts)->sum('total_cost'), 2) }} USD
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

            @elseif($activeReport === 'low_stock')
                <!-- Low Stock Report -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-300">
                        <thead class="bg-slate-700/50 border-b border-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المنتج</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">SKU</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الصنف</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الكمية الحالية</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الحد الأدنى</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الفرق</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($lowStockProducts ?? [] as $product)
                                <tr class="hover:bg-slate-700/30 transition-colors {{ $product['current_stock'] <= 0 ? 'bg-red-500/10' : '' }}">
                                    <td class="px-4 py-3 font-medium text-gray-100">{{ $product['name'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['sku'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['category'] ?? '-' }}</td>
                                    <td class="px-4 py-3 font-bold text-red-400">{{ $product['current_stock'] }} {{ $product['unit_of_measure'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['reorder_level'] }}</td>
                                    <td class="px-4 py-3 text-yellow-400">
                                        {{ $product['current_stock'] - $product['reorder_level'] }} {{ $product['unit_of_measure'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">لا توجد منتجات منخفضة المخزون</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif($activeReport === 'movement')
                <!-- Movement Report -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-300">
                        <thead class="bg-slate-700/50 border-b border-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-gray-400 font-semibold">التاريخ</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المنتج</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">نوع الحركة</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الكمية</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المستخدم</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($movements ?? [] as $movement)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 text-gray-400">{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-100">{{ $movement->product->name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if(in_array($movement->transaction_type, ['purchase', 'return_sale', 'adjustment']))
                                            <span class="px-2 py-1 bg-green-500/20 text-green-400 rounded-lg text-xs">
                                                {{ $movement->transaction_type === 'purchase' ? 'شراء' : ($movement->transaction_type === 'return_sale' ? 'إرجاع بيع' : 'تعديل') }}
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-red-500/20 text-red-400 rounded-lg text-xs">
                                                {{ $movement->transaction_type === 'sale' ? 'بيع' : 'إرجاع شراء' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 {{ in_array($movement->transaction_type, ['purchase', 'return_sale', 'adjustment']) ? 'text-green-400' : 'text-red-400' }}">
                                        {{ in_array($movement->transaction_type, ['purchase', 'return_sale', 'adjustment']) ? '+' : '-' }}{{ $movement->quantity }}
                                    </td>
                                    <td class="px-4 py-3 text-gray-400">{{ $movement->user->name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $movement->notes ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">لا توجد حركات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if(isset($movements))
                        <div class="mt-4">{{ $movements->links() }}</div>
                    @endif
                </div>

            @elseif($activeReport === 'sales_by_product')
                <!-- Sales by Product Report -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-300">
                        <thead class="bg-slate-700/50 border-b border-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المنتج</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">SKU</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">عدد الفواتير</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الكمية المباعة</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الإيرادات</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">التكلفة</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الربح</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">هامش الربح %</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($salesByProduct ?? [] as $sale)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-100">{{ $sale['product_name'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $sale['sku'] }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $sale['invoice_count'] }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $sale['total_quantity'] }}</td>
                                    <td class="px-4 py-3 font-semibold text-green-400">{{ number_format($sale['total_revenue'], 2) }} USD</td>
                                    <td class="px-4 py-3 text-gray-300">{{ number_format($sale['total_cost'], 2) }} USD</td>
                                    <td class="px-4 py-3 font-semibold {{ $sale['profit'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($sale['profit'], 2) }} USD
                                    </td>
                                    <td class="px-4 py-3 {{ $sale['profit_margin'] >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($sale['profit_margin'], 2) }}%
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">لا توجد مبيعات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif($activeReport === 'sales_by_period')
                <!-- Sales by Period Report -->
                <div class="space-y-6">
                    <!-- Daily Sales -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-100 mb-4">المبيعات اليومية</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-right text-gray-300">
                                <thead class="bg-slate-700/50 border-b border-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 text-gray-400 font-semibold">التاريخ</th>
                                        <th class="px-4 py-3 text-gray-400 font-semibold">المبيعات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/50">
                                    @forelse($dailySales ?? [] as $day)
                                        <tr class="hover:bg-slate-700/30 transition-colors">
                                            <td class="px-4 py-3 text-gray-300">{{ $day['date_formatted'] }}</td>
                                            <td class="px-4 py-3 font-semibold text-green-400">{{ number_format($day['sales'], 2) }} USD</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-8 text-center text-gray-400">لا توجد بيانات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Weekly Sales -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-100 mb-4">المبيعات الأسبوعية</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-right text-gray-300">
                                <thead class="bg-slate-700/50 border-b border-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 text-gray-400 font-semibold">الأسبوع</th>
                                        <th class="px-4 py-3 text-gray-400 font-semibold">المبيعات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/50">
                                    @forelse($weeklySales ?? [] as $week)
                                        <tr class="hover:bg-slate-700/30 transition-colors">
                                            <td class="px-4 py-3 text-gray-300">{{ $week['week'] }}</td>
                                            <td class="px-4 py-3 font-semibold text-green-400">{{ number_format($week['sales'], 2) }} USD</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-8 text-center text-gray-400">لا توجد بيانات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Monthly Sales -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-100 mb-4">المبيعات الشهرية</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-right text-gray-300">
                                <thead class="bg-slate-700/50 border-b border-slate-600">
                                    <tr>
                                        <th class="px-4 py-3 text-gray-400 font-semibold">الشهر</th>
                                        <th class="px-4 py-3 text-gray-400 font-semibold">المبيعات</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-700/50">
                                    @forelse($monthlySales ?? [] as $month)
                                        <tr class="hover:bg-slate-700/30 transition-colors">
                                            <td class="px-4 py-3 text-gray-300">{{ $month['month_formatted'] }}</td>
                                            <td class="px-4 py-3 font-semibold text-green-400">{{ number_format($month['sales'], 2) }} USD</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-8 text-center text-gray-400">لا توجد بيانات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            @elseif($activeReport === 'slow_moving')
                <!-- Slow Moving Report -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-300">
                        <thead class="bg-slate-700/50 border-b border-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المنتج</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">SKU</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الصنف</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">الكمية الحالية</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">آخر بيع</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">أيام بدون بيع</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">التكلفة الإجمالية</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($slowMovingProducts ?? [] as $product)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-100">{{ $product['name'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['sku'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['category'] ?? '-' }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $product['current_stock'] }}</td>
                                    <td class="px-4 py-3 text-gray-400">{{ $product['last_sale_date'] }}</td>
                                    <td class="px-4 py-3 text-yellow-400">{{ $product['days_without_sale'] }}</td>
                                    <td class="px-4 py-3 font-semibold text-red-400">{{ number_format($product['total_cost'], 2) }} USD</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">لا توجد منتجات راكدة</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            @elseif($activeReport === 'profit_loss')
                <!-- Profit & Loss Report -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-700/30 rounded-xl p-6 border border-slate-600">
                        <h3 class="text-lg font-bold text-gray-100 mb-4">ملخص الأرباح والخسائر</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">الإيرادات (المبيعات):</span>
                                <span class="font-bold text-green-400">{{ number_format($revenue ?? 0, 2) }} USD</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">تكلفة البضاعة المباعة (COGS):</span>
                                <span class="font-bold text-red-400">-{{ number_format($cogs ?? 0, 2) }} USD</span>
                            </div>
                            <div class="border-t border-slate-600 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-200 font-semibold">الربح الإجمالي:</span>
                                    <span class="font-bold text-lg {{ ($grossProfit ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($grossProfit ?? 0, 2) }} USD
                                    </span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    هامش الربح الإجمالي: {{ number_format($grossMargin ?? 0, 2) }}%
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-300">المشتريات:</span>
                                <span class="font-bold text-red-400">-{{ number_format($purchases ?? 0, 2) }} USD</span>
                            </div>
                            <div class="border-t border-slate-600 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-200 font-bold text-lg">صافي الربح:</span>
                                    <span class="font-bold text-xl {{ ($netProfit ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                        {{ number_format($netProfit ?? 0, 2) }} USD
                                    </span>
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    هامش الربح الصافي: {{ number_format($netMargin ?? 0, 2) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif($activeReport === 'customer_sales')
                <!-- Customer Sales Report -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-300">
                        <thead class="bg-slate-700/50 border-b border-slate-600">
                            <tr>
                                <th class="px-4 py-3 text-gray-400 font-semibold">العميل</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">عدد الفواتير</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">إجمالي المشتريات</th>
                                <th class="px-4 py-3 text-gray-400 font-semibold">المنتجات المفضلة</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            @forelse($customerSales ?? [] as $customer)
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 font-medium text-gray-100">{{ $customer['customer_name'] }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $customer['invoice_count'] }}</td>
                                    <td class="px-4 py-3 font-semibold text-green-400">{{ number_format($customer['total_spent'], 2) }} USD</td>
                                    <td class="px-4 py-3 text-gray-400">
                                        @if($customer['top_products']->count() > 0)
                                            <div class="space-y-1">
                                                @foreach($customer['top_products'] as $product)
                                                    <div class="text-xs">{{ $product['product_name'] }} ({{ $product['quantity'] }})</div>
                                                @endforeach
                                            </div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400">لا توجد بيانات</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
