<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'لوحة التحكم - نظام إدارة المخزن' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-indigo-50/30 to-purple-50/30 text-gray-900 antialiased">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed right-0 top-0 h-screen w-72 bg-gradient-to-b from-slate-900 via-slate-800 to-slate-900 shadow-2xl" style="z-index: 40;">
            <!-- Logo -->
            <div class="p-6 border-b border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg flex items-center justify-center text-white text-2xl">
                        ⚡
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">لوحة التحكم</h1>
                        <p class="text-xs text-slate-400">نظام إدارة المخزون</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-180px)]">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <span class="font-semibold">الرئيسية</span>
                </a>

                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">إدارة المخزون</p>
                </div>

                <a href="{{ route('admin.categories') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.categories') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.categories') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="font-semibold">الأصناف</span>
                </a>

                <a href="{{ route('admin.products') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.products') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.products') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="font-semibold">المنتجات</span>
                </a>

                <a href="{{ route('admin.companies') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.companies') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.companies') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-semibold">الشركات</span>
                </a>

                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">المبيعات والعملاء</p>
                </div>

                <a href="{{ route('admin.customers') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.customers') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.customers') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">الزبائن</span>
                </a>

                <a href="{{ route('admin.orders') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.orders') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.orders') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-semibold">الطلبات</span>
                </a>

                <a href="{{ route('admin.sales-invoices') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.sales-invoices') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.sales-invoices') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold">فواتير البيع</span>
                </a>

                <a href="{{ route('admin.purchase-invoices') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.purchase-invoices') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.purchase-invoices') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">فواتير الشراء</span>
                </a>

                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">الإعدادات</p>
                </div>

                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all group {{ request()->routeIs('admin.settings') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/50' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-white/20' : 'bg-slate-700/50 group-hover:bg-slate-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold">الإعدادات</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-slate-700">
                <a href="{{ route('client.catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-300 hover:bg-slate-700/50 transition-all group">
                    <div class="p-2 rounded-lg bg-slate-700/50 group-hover:bg-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <span class="font-semibold">عرض الموقع</span>
                </a>
            </div>
        </aside>

        <!-- Main Content with margin -->
        <div class="mr-72">
            <!-- Top Bar -->
            <header class="sticky top-0 bg-white/90 backdrop-blur-lg border-b border-gray-200 shadow-sm" style="z-index: 30;">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? '' }}</h1>
                        <p class="text-sm text-gray-500">مرحباً بك في لوحة التحكم</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <button class="relative p-2 rounded-xl hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div class="flex items-center gap-3 p-2 pr-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg">
                            <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-sm">
                                A
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white">المدير</p>
                                <p class="text-xs text-indigo-100">مشرف النظام</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6 min-h-screen">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
