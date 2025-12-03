<<<<<<< HEAD
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl overflow-hidden shadow-2xl">
        <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:30px_30px]"></div>
        <div class="relative px-8 py-10">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">مرحباً بك، المدير! 👋</h2>
                    <p class="text-indigo-100 text-lg">إليك نظرة سريعة على أداء نظام المخزون اليوم</p>
                </div>
                <div class="hidden lg:block text-white/20 text-9xl">📊</div>
            </div>
        </div>
        <div class="absolute top-0 left-0 w-64 h-64 bg-white/10 rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-pink-500/20 rounded-full translate-x-1/3 translate-y-1/3"></div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Sales -->
        <div class="relative bg-white rounded-2xl p-6 shadow-lg border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400/20 to-emerald-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl shadow-lg shadow-green-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1 rounded-full">+12%</span>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">إجمالي المبيعات</h3>
                <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_sales'], 2) }} <span class="text-lg text-gray-500">ر.س</span></p>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="relative bg-white rounded-2xl p-6 shadow-lg border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg shadow-blue-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">نشط</span>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">الطلبات المعلقة</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['pending_orders'] }}</p>
            </div>
        </div>

        <!-- Products -->
        <div class="relative bg-white rounded-2xl p-6 shadow-lg border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg shadow-purple-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
=======
<div>
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">إجمالي المبيعات</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($stats['total_sales'], 2) }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">الطلبات المعلقة</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['pending_orders'] }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">المنتجات</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['products'] }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">إجمالي المنتجات</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['products'] }}</p>
            </div>
        </div>

<<<<<<< HEAD
        <!-- Categories -->
        <div class="relative bg-white rounded-2xl p-6 shadow-lg border border-gray-100 overflow-hidden group hover:shadow-2xl transition-all">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-400/20 to-orange-500/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform"></div>
            <div class="relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg shadow-orange-500/50">
                        <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-gray-600 text-sm font-semibold mb-1">الأصناف</h3>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['categories'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                        <div class="p-2 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        أحدث الطلبات
                    </h3>
                    <a href="#" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        عرض الكل
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">رقم الطلب</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">الزبون</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">التاريخ</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">المبلغ</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">الحالة</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                            <tr class="hover:bg-indigo-50/50 transition-colors">
                                <td class="px-6 py-4 font-bold text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 text-gray-700 font-medium">{{ $order->customer?->user?->name ?? 'زائر' }}</td>
                                <td class="px-6 py-4 text-gray-600 text-xs">{{ $order->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 font-bold text-green-600">{{ number_format($order->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                        قيد المراجعة
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button class="text-indigo-600 hover:text-indigo-700 font-bold">التفاصيل</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-gray-500 font-semibold">لا توجد طلبات حديثة</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
=======
        <div class="bg-white rounded-lg p-6 border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600">الشركات</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $stats['companies'] }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
            </div>
        </div>
    </div>

<<<<<<< HEAD
        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                <div class="p-2 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg">
                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                إجراءات سريعة
            </h3>
            <div class="space-y-3">
                <a href="{{ route('admin.products') }}" class="block p-4 bg-gradient-to-br from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-xl border border-blue-200 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-blue-600 rounded-lg shadow-lg shadow-blue-600/50 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">إضافة منتج جديد</span>
                    </div>
                </a>

                <a href="{{ route('admin.categories') }}" class="block p-4 bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 rounded-xl border border-purple-200 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-purple-600 rounded-lg shadow-lg shadow-purple-600/50 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">إدارة الأصناف</span>
                    </div>
                </a>

                <a href="{{ route('admin.companies') }}" class="block p-4 bg-gradient-to-br from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-xl border border-green-200 transition-all group">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-green-600 rounded-lg shadow-lg shadow-green-600/50 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="font-bold text-gray-900">إدارة الشركات</span>
                    </div>
                </a>
            </div>
=======
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-bold text-slate-800">أحدث الطلبات</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">رقم الطلب</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">الزبون</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">التاريخ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">المبلغ</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-medium text-slate-800">#{{ $order->id }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $order->customer->name ?? 'زائر' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600">{{ $order->created_at->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-800">{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    معلق
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                لا توجد طلبات حالياً
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
        </div>
    </div>
</div>
