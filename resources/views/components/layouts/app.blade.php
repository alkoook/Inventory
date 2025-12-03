<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'نظام إدارة المخزن' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 text-gray-900 antialiased">
    <div class="min-h-screen">
        <!-- Sidebar -->
        <aside class="fixed right-0 top-0 h-screen w-72 bg-white shadow-xl border-l border-gray-200" style="z-index: 40;">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-br from-indigo-600 to-blue-600">
                <a href="{{ route('client.catalog') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-lg flex items-center justify-center text-2xl transform group-hover:scale-105 transition-transform">
                        📦
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-white">متجر المخزن</h1>
                        <p class="text-xs text-indigo-100">تسوق بثقة وراحة</p>
                    </div>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto h-[calc(100vh-180px)]">
                <a href="{{ route('client.catalog') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.catalog') || request()->routeIs('client.product.details') ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg shadow-indigo-500/50' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="font-semibold">الصفحة الرئيسية</span>
                </a>

                <a href="{{ route('client.companies') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.companies') || request()->routeIs('client.company.details') ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg shadow-indigo-500/50' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    <span class="font-semibold">الشركات الموردة</span>
                </a>

                <a href="{{ route('client.card') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('client.card') ? 'bg-gradient-to-r from-indigo-600 to-blue-600 text-white shadow-lg shadow-indigo-500/50' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-semibold">سلة المشتريات</span>
                </a>
            </nav>

            <!-- Footer -->
            <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-gray-200 bg-gradient-to-br from-gray-50 to-indigo-50">
                <div class="flex items-center gap-3 p-3 bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-600 to-blue-600 flex items-center justify-center text-white font-bold text-sm">
                        ز
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-bold text-gray-900">زائر</p>
                        <p class="text-xs text-gray-500">العميل</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content with margin -->
        <div class="mr-72">
            <!-- Top Bar -->
            <header class="sticky top-0 bg-white/90 backdrop-blur-lg border-b border-gray-200 shadow-sm" style="z-index: 30;">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input type="search" placeholder="ابحث عن منتج..." class="w-64 pl-10 pr-4 py-2 rounded-xl border border-gray-300 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-600/20 transition-all bg-gray-50">
                            <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <button class="relative p-2 rounded-xl hover:bg-gray-100 transition-colors">
                            <svg class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
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
