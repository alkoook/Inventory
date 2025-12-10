<div>
    <!-- الإحصائيات الأساسية -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- المنتجات -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-slate-700/50 smooth-transition hover:shadow-blue-500/20 hover:border-blue-500/30" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">المنتجات</p>
                <div class="text-blue-400 bg-blue-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold text-gray-100">{{ $stats['products'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">إجمالي المنتجات</p>
        </div>

        <!-- الأصناف -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-slate-700/50 smooth-transition hover:shadow-blue-500/20 hover:border-blue-500/30" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الأصناف</p>
                <div class="text-blue-400 bg-blue-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold text-gray-100">{{ $stats['categories'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">إجمالي الأصناف</p>
        </div>

        <!-- الشركات -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-slate-700/50 smooth-transition hover:shadow-red-500/20 hover:border-red-500/30" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الشركات</p>
                <div class="text-red-400 bg-red-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold text-gray-100">{{ $stats['companies'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">إجمالي الشركات</p>
        </div>

        <!-- الزبائن -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-slate-700/50 smooth-transition hover:shadow-blue-500/20 hover:border-blue-500/30" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(59, 130, 246, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الزبائن</p>
                <div class="text-blue-400 bg-blue-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold text-gray-100">{{ $stats['customers'] ?? 0 }}</p>
            <p class="text-xs text-gray-400 mt-1">إجمالي الزبائن</p>
        </div>
    </div>

    <!-- إحصائيات المالية -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- الوارد (فواتير البيع) -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-green-500/30 smooth-transition hover:shadow-green-500/20" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(34, 197, 94, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الوارد (فواتير البيع)</p>
                <div class="text-green-400 bg-green-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.3);">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold text-green-400">{{ number_format($totalSales ?? 0, 2) }} USD</p>
            <p class="text-xs text-gray-400 mt-1">إجمالي فواتير البيع</p>
        </div>

        <!-- الصادر (فواتير الشراء) -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-red-500/30 smooth-transition hover:shadow-red-500/20" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(239, 68, 68, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الصادر (فواتير الشراء)</p>
                <div class="text-red-400 bg-red-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold text-red-400">{{ number_format($totalPurchases ?? 0, 2) }} USD</p>
            <p class="text-xs text-gray-400 mt-1">إجمالي فواتير الشراء</p>
        </div>

        <!-- الربح/الخسارة الإجمالي -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border {{ ($totalProfit ?? 0) >= 0 ? 'border-green-500/30' : 'border-red-500/30' }} smooth-transition" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px {{ ($totalProfit ?? 0) >= 0 ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }};">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الربح/الخسارة الإجمالي</p>
                <div class="{{ ($totalProfit ?? 0) >= 0 ? 'text-green-400 bg-green-500/20' : 'text-red-400 bg-red-500/20' }} p-2 rounded-full" style="box-shadow: 0 0 15px {{ ($totalProfit ?? 0) >= 0 ? 'rgba(34, 197, 94, 0.3)' : 'rgba(239, 68, 68, 0.3)' }};">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                </div>
            </div>
            <p class="mt-4 text-3xl font-extrabold {{ ($totalProfit ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">{{ number_format($totalProfit ?? 0, 2) }} USD</p>
            <p class="text-xs text-gray-400 mt-1">{{ ($totalProfit ?? 0) >= 0 ? 'ربح إجمالي' : 'خسارة إجمالية' }}</p>
        </div>
    </div>

    <!-- إحصائيات الشهر -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- الوارد الشهر -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-green-500/30 smooth-transition hover:shadow-green-500/20" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(34, 197, 94, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الوارد الشهر</p>
                <div class="text-green-400 bg-green-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(34, 197, 94, 0.3);">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-2xl font-extrabold text-green-400">{{ number_format($monthSales ?? 0, 2) }} USD</p>
            <p class="text-xs text-gray-400 mt-1">فواتير البيع هذا الشهر</p>
        </div>

        <!-- الصادر الشهر -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border border-red-500/30 smooth-transition hover:shadow-red-500/20" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px rgba(239, 68, 68, 0.1);">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الصادر الشهر</p>
                <div class="text-red-400 bg-red-500/20 p-2 rounded-full" style="box-shadow: 0 0 15px rgba(239, 68, 68, 0.3);">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            </div>
            <p class="mt-4 text-2xl font-extrabold text-red-400">{{ number_format($monthPurchases ?? 0, 2) }} USD</p>
            <p class="text-xs text-gray-400 mt-1">فواتير الشراء هذا الشهر</p>
        </div>

        <!-- الربح/الخسارة الشهر -->
        <div class="bg-slate-800 p-6 rounded-2xl shadow-xl border {{ ($monthProfit ?? 0) >= 0 ? 'border-green-500/30' : 'border-red-500/30' }} smooth-transition" style="box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 15px {{ ($monthProfit ?? 0) >= 0 ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)' }};">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-gray-400">الربح/الخسارة الشهر</p>
                <div class="{{ ($monthProfit ?? 0) >= 0 ? 'text-green-400 bg-green-500/20' : 'text-red-400 bg-red-500/20' }} p-2 rounded-full" style="box-shadow: 0 0 15px {{ ($monthProfit ?? 0) >= 0 ? 'rgba(34, 197, 94, 0.3)' : 'rgba(239, 68, 68, 0.3)' }};">
                    @if(($monthProfit ?? 0) >= 0)
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                    @endif
                </div>
            </div>
            <p class="mt-4 text-2xl font-extrabold {{ ($monthProfit ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">{{ number_format($monthProfit ?? 0, 2) }} USD</p>
            <p class="text-xs {{ ($monthProfit ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }} mt-1 font-semibold">
                {{ ($monthProfit ?? 0) >= 0 ? 'أنت رابح هذا الشهر' : 'أنت خاسر هذا الشهر' }}
            </p>
        </div>
    </div>
</div>
