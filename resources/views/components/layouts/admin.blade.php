<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- TomSelect CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">

    @stack('styles')
    
    <style>
        {{--  @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');  --}}
        body {
            font-family: 'Cairo', sans-serif;
            background: #1e293b;

        }
        
        /* 1. Base Transitions */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* 2. Sidebar Styling & Visibility - Dark Theme */
        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 50;
            width: 18rem; /* w-72 */
            transform: translateX(100%); /* Initially hide off-screen (Mobile) */
            transition: transform 0.3s ease-in-out;
            /* Dark Theme - Clean and Comfortable */
            background: #1e293b;
            box-shadow: -8px 0 30px rgba(0, 0, 0, 0.3);
        }

        /* Class added by JS to show the sidebar */
        #sidebar.open {
            transform: translateX(0);
        }

        /* Backdrop effect for mobile - Dark Theme */
        #backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            z-index: 40;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }

        #backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* 3. Tablet (md) and Desktop (lg) specific sidebar visibility and main content spacing */
        @media (min-width: 768px) {
            #sidebar {
                transform: translateX(0); /* Always visible on Tablet/Desktop */
            }
            #sidebar.hidden-desktop {
                transform: translateX(100%); /* Hide on desktop when toggled */
            }
            .main-content {
                margin-right: 18rem; /* Reserve space for the WIDER sidebar (18rem) */
                transition: margin-right 0.3s ease-in-out;
            }
            .main-content.full-width {
                margin-right: 0; /* Full width when sidebar is hidden */
            }
        }
        
        /* 4. Enhanced Navigation Links - Dark Theme with Poetic Colors */
        .nav-link {
            position: relative;
            overflow: hidden;
            z-index: 10;
        }

        .nav-link:hover {
            transform: translateY(-1px);
            background: rgba(30, 41, 59, 0.5);
        }

        /* Style for the active link: clean blue */
        .active-link {
            background: rgba(37, 99, 235, 0.2);
            border-right: 3px solid #2563eb;
        }
        
        .active-link .p-2 {
            background: rgba(37, 99, 235, 0.3) !important;
        }
        
        /* Dark theme scrollbar */
        /* Hide scrollbar but keep functionality */
        nav {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        nav::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>

    @livewireStyles



</head>
<body class="bg-slate-900 text-gray-100 antialiased">
    <div class="min-h-screen">
        <!-- Backdrop for mobile sidebar -->
        <div id="backdrop" onclick="toggleSidebar()"></div>

        <!-- Sidebar (RTL: fixed right) -->
        <aside id="sidebar" class="fixed right-0 top-0 h-screen w-72 p-0 smooth-transition">
            <!-- Header Area - Dark Theme -->
            <div class="p-6 border-b border-slate-700/50">
                <h1 class="text-xl font-bold text-gray-100">لوحة التحكم</h1>
                <p class="text-xs text-gray-400">نظام إدارة المخزون</p>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-180px)]">
                <!-- 
                    NOTE: The first link is set to active (Dashboard) for demonstration. 
                    I am using static '#' links instead of Blade routes.
                -->

                @if(!auth()->user()->hasRole('worker'))
                @if(auth()->user()->hasRole('admin'))
                <!-- الرئيسية (Dashboard) -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.dashboard') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-blue-500/20 text-blue-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <span>الرئيسية</span>
                </a>
                @endif

                <!-- الإدارة (Management) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">إدارة المخزون</p>
                </div>

                <!-- الأصناف (Categories) -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.categories.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="font-medium">الأصناف</span>
                </a>

                <!-- المنتجات (Products) -->
                <a href="{{ route('admin.products.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.products.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="font-medium">المنتجات</span>
                </a>

                <!-- المخزون (Inventory) -->
                <a href="{{ route('admin.inventory.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.inventory.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="font-medium">المخزون</span>
                </a>

                <!-- الشركات (Companies) -->
                <a href="{{ route('admin.companies.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.companies.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-medium">الشركات</span>
                </a>

                <!-- المبيعات والعملاء (Sales & Customers) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">المبيعات والعملاء</p>
                </div>

           
                <!-- الطلبات (Orders) -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.orders.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-medium">الطلبات</span>
                </a>

                <!-- فواتير البيع (Sales Invoices) -->
                <a href="{{ route('admin.sales-invoices.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.sales-invoices.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">فواتير البيع</span>
                </a>

                <!-- فواتير الشراء (Purchase Invoices) -->
                <a href="{{ route('admin.purchase-invoices.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.purchase-invoices.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">فواتير الشراء</span>
                </a>

                <!-- العاملين (Workers) -->
                <a href="{{ route('admin.workers.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.workers.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">العاملين</span>
                </a>
                @endif

                @if(auth()->user()->hasRole('admin'))
                <!-- التقارير (Reports) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">التقارير</p>
                </div>

                <!-- التقارير (Reports) -->
                <a href="{{ route('admin.reports.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.reports.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="font-medium">التقارير</span>
                </a>
                @endif

                @if(!auth()->user()->hasRole('worker'))
                <!-- الإعدادات (Settings) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">النظام</p>
                </div>

                <!-- الإشعارات (Notifications) -->
                <a href="{{ route('admin.notifications.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.notifications.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }} relative">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20 relative">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <span class="font-medium">الإشعارات</span>
                    @php
                        $unreadCount = \App\Models\Notification::unreadCount();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="absolute right-2 top-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                        </span>
                    @endif
                </a>
                @endif

                @if(auth()->user()->hasRole('admin'))
                <!-- الإعدادات (Settings) -->
                <a href="{{ route('admin.settings') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.settings') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">الإعدادات</span>
                </a>
                
                <!-- المستخدمين (Users) -->
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.users.*') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">المستخدمين</span>
                </a>
                @endif

                @if(auth()->user()->hasRole('worker'))
                <!-- فواتيري (My Invoices) -->
                <a href="{{ route('admin.workers.my-invoices') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition {{ request()->routeIs('admin.workers.my-invoices') ? 'active-link text-blue-400 font-semibold' : 'text-gray-300 hover:text-gray-100 hover:bg-slate-700/50' }}">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">فواتيري</span>
                </a>
                @endif


                    <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">تسجيل الخروج</p>
                </div>
              <form action ="{{ route('admin.logout') }}" method="POST"
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-gray-300 hover:text-red-400 hover:bg-red-500/10">
                @csrf

                    <div class="p-2 rounded-lg bg-red-500/20 text-red-400 group-hover:bg-red-500/30" style="box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </div>
                    <button type="submit" class="font-medium">تسجيل الخروج</button>
                </form>
          {{--        <!-- التقارير (Reports) Section - Kept for structure -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">التقارير</p>
                </div>  --}}
                
                {{--  <!-- تقارير إضافية (Placeholder links) -->
                 <a href="{{ route('admin.reports.financial') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">التقارير المالية</span>
                </a>

                <a href="{{ route('admin.reports.inventory') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6" />
                        </svg>
                    </div>
                    <span class="font-medium">تقارير المخزون</span>
                </a>  --}}

            </nav>

            <!-- Sidebar Footer: View Client Catalog -->
            <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-slate-700/50">
                <a href="{{ route('client.catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-300 hover:text-blue-400 hover:bg-slate-700/50 transition-all group">
                    <div class="p-2 rounded-lg bg-slate-700/50 text-blue-400 group-hover:bg-blue-500/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <span class="font-medium">عرض الموقع</span>
                </a>
            </div>
        </aside>

        <!-- Fixed Toggle Button (Top Right Corner) -->
        <button class="fixed top-4 right-4 z-50 p-2.5 rounded-xl bg-slate-800/95 backdrop-blur-sm border border-slate-700/50 text-gray-300 hover:text-blue-400 hover:bg-slate-700/70 transition-all shadow-lg hover:shadow-xl" onclick="toggleSidebar()" id="sidebar-toggle">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="menu-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="close-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Main Content Wrapper (Used for desktop margin) -->
        <div class="main-content">
            <!-- Page Content Placeholder -->
            <main class="p-6 min-h-screen" style="background: transparent;">
                {{ $slot }}
            </main>
        </div>
    </div>




    @livewireScripts

    <script>
        // Get references to the sidebar and backdrop elements
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('backdrop');
        const mainContent = document.querySelector('.main-content');
        const topbar = document.querySelector('.topbar-margin');

        // Function to toggle the sidebar's open state
        function toggleSidebar() {
            const isMobile = window.innerWidth < 768;
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            const toggleButton = document.getElementById('sidebar-toggle');
            
            if (isMobile) {
                // Mobile behavior
                const isOpen = sidebar.classList.contains('open');
                if (isOpen) {
                    sidebar.classList.remove('open');
                    backdrop.classList.remove('open');
                } else {
                    sidebar.classList.add('open');
                    backdrop.classList.add('open');
                }
            } else {
                // Desktop behavior - toggle sidebar visibility
                const isHidden = sidebar.classList.contains('hidden-desktop');
                if (isHidden) {
                    sidebar.classList.remove('hidden-desktop');
                    mainContent.classList.remove('full-width');
                    toggleButton.classList.remove('full-width');
                    menuIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    sidebar.classList.add('hidden-desktop');
                    mainContent.classList.add('full-width');
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            }
        }

        // Adjust layout on window resize to handle responsiveness
        function handleResize() {
            // Check if viewport is wide enough (md: breakpoint)
            if (window.innerWidth >= 768) {
                // For desktop/tablet, ensure sidebar is visible and mobile toggle is reset
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
            }
        }
        
        // Initial setup and listener for resizing
        window.addEventListener('load', handleResize);
        window.addEventListener('resize', handleResize);
        
    </script>

    {{-- Tailwind CSS v4 is configured in resources/css/app.css --}}
    <script>
        function initTomSelects() {
            document.querySelectorAll('.product-select').forEach((el) => {
                if (!el.tomselect) {
                    let index = el.dataset.index;

                    let ts = new TomSelect(el, {
                        placeholder: "ابحث عن منتج...",
                        maxItems: 1,
                        allowEmptyOption: true,
                    });

                    ts.on('change', function(value) {
                        Livewire.dispatch('update-product', { 
                            index: index, 
                            product_id: value 
                        });
                    });
                }
            });

            document.querySelectorAll('.customer-select').forEach((el) => {
                if (!el.tomselect) {
                    new TomSelect(el, {
                        placeholder: "اختر زبون...",
                        maxItems: 1,
                        allowEmptyOption: true,
                    });
                }
            });
        }

        document.addEventListener('livewire:load', initTomSelects);
        document.addEventListener('livewire:update', initTomSelects);
    </script>

</body>
</html>