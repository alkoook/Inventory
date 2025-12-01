<div>
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sales -->
        <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-lg shadow-black/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-emerald-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-400 bg-emerald-500/10 px-2 py-1 rounded-lg">+12%</span>
            </div>
            <h3 class="text-gray-400 text-sm font-medium">إجمالي المبيعات</h3>
            <p class="text-2xl font-bold text-white mt-1">{{ number_format($stats['total_sales'], 2) }} ر.س</p>
        </div>

        <!-- Pending Orders -->
        <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-lg shadow-black/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-400 bg-blue-500/10 px-2 py-1 rounded-lg">نشط</span>
            </div>
            <h3 class="text-gray-400 text-sm font-medium">الطلبات المعلقة</h3>
            <p class="text-2xl font-bold text-white mt-1">{{ $stats['pending_orders'] }}</p>
        </div>

        <!-- Products -->
        <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-lg shadow-black/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-purple-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <h3 class="text-gray-400 text-sm font-medium">إجمالي المنتجات</h3>
            <p class="text-2xl font-bold text-white mt-1">{{ $stats['products'] }}</p>
        </div>

        <!-- Low Stock -->
        {{--  <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-lg shadow-black/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-red-500/10 rounded-xl">
                    <svg class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-red-400 bg-red-500/10 px-2 py-1 rounded-lg">تنبيه</span>
            </div>
            <h3 class="text-gray-400 text-sm font-medium">منتجات منخفضة المخزون</h3>
            <p class="text-2xl font-bold text-white mt-1">{{ $stats['low_stock'] }}</p>
        </div>  --}}
    </div>

    <!-- Recent Activity & Charts Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-slate-800 rounded-2xl border border-slate-700 shadow-lg shadow-black/20 overflow-hidden">
            <div class="p-6 border-b border-slate-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-white">أحدث الطلبات</h3>
                <a href="#" class="text-sm text-cyan-400 hover:text-cyan-300">عرض الكل</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead class="bg-slate-900/50 text-gray-400 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-4 font-medium">رقم الطلب</th>
                            <th class="px-6 py-4 font-medium">الزبون</th>
                            <th class="px-6 py-4 font-medium">التاريخ</th>
                            <th class="px-6 py-4 font-medium">المبلغ</th>
                            <th class="px-6 py-4 font-medium">الحالة</th>
                            <th class="px-6 py-4 font-medium">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700">
                        @forelse($recentOrders as $order)
                            <tr class="text-sm text-gray-300 hover:bg-slate-700/50 transition-colors">
                                <td class="px-6 py-4">#{{ $order->id }}</td>
                                <td class="px-6 py-4 font-medium text-white">{{ $order->customer?->user?->name ?? 'زائر' }}</td>
                                <td class="px-6 py-4">{{ $order->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 font-bold text-emerald-400">{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-500/10 text-yellow-500">
                                        قيد المراجعة
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-cyan-400 hover:text-cyan-300 font-medium">التفاصيل</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    لا توجد طلبات حديثة
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions / Notifications -->
        <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg shadow-black/20 p-6">
            <h3 class="text-lg font-bold text-white mb-6">إجراءات سريعة</h3>
            <div class="space-y-4">
                <button class="w-full flex items-center justify-between p-4 rounded-xl bg-slate-700/50 hover:bg-slate-700 border border-slate-600 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-cyan-500/10 rounded-lg text-cyan-400 group-hover:bg-cyan-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-200">إضافة منتج جديد</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <button class="w-full flex items-center justify-between p-4 rounded-xl bg-slate-700/50 hover:bg-slate-700 border border-slate-600 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-500/10 rounded-lg text-purple-400 group-hover:bg-purple-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-200">إنشاء فاتورة شراء</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <button class="w-full flex items-center justify-between p-4 rounded-xl bg-slate-700/50 hover:bg-slate-700 border border-slate-600 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <span class="font-medium text-gray-200">تسجيل زبون جديد</span>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 group-hover:text-white transition-colors rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
