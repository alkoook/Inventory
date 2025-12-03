<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'لوحة التحكم الزرقاء الحيوية' }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'Tahoma', 'Arial', 'sans-serif'],
                    },
                    // Color Palette: Deep Indigo for structure, Electric Blue for accent
                    colors: {
                        'primary': {
                            50: '#f0f3ff',   // Light background
                            100: '#eef2ff',
                            200: '#c7d2fe',
                            600: '#4f46e5',   // Rich Blue (Indigo-600)
                            700: '#4338ca',   // Main structural Blue (Deep Indigo)
                            900: '#1e3a8a',   // Deepest Indigo for contrast
                        },
                        'accent': '#3b82f6', // Bright, Electric Blue for highlights/vibrancy
                        'dark-slate': '#1e293b',
                    }
                }
            }
        }
    </script>
    <style>
        /*
        * CSS FOR DESIGN AND ANIMATIONS & TABLET/DESKTOP RESPONSIVENESS
        */

        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* 1. Sidebar Styling & Visibility */
        #sidebar {
            /* Full screen height, fixed position */
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 50;
            width: 18rem; /* NEW WIDER SIZE: w-72 */
            transform: translateX(100%); /* Initially hide off-screen (Mobile) */
            transition: transform 0.3s ease-in-out;
            background-color: #fff; /* Default background for mobile */
        }

        /* Class added by JS to show the sidebar */
        #sidebar.open {
            transform: translateX(0);
        }

        /* Backdrop effect for mobile */
        #backdrop {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }

        #backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }

        /* 2. Tablet (md) and Desktop (lg) specific sidebar visibility and main content spacing */
        @media (min-width: 768px) {
            #sidebar {
                transform: translateX(0); /* Always visible on Tablet/Desktop */
                /* Added subtle gradient for a 'lively' feel */
                background-image: linear-gradient(to bottom, #ffffff, #f7f9fd);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); /* Stronger shadow for elegance */
                border-right: 1px solid #eef2ff; /* Soft border on the left side */
            }
            .main-content {
                margin-right: 18rem; /* Reserve space for the WIDER sidebar (18rem) */
            }
        }

        /* 3. Enhanced Navigation Links - More Lively and Pop */
        .nav-link {
            /* Base style */
            position: relative;
            overflow: hidden;
            z-index: 10;
        }

        .nav-link:hover {
            transform: translateY(-2px);
            /* Increased shadow opacity and spread for lively feel */
            box-shadow: 0 12px 20px -5px rgba(59, 130, 246, 0.4), 0 6px 8px -4px rgba(59, 130, 246, 0.2);
        }

        .active-link {
             /* Strong, vibrant blue glow for active state */
             box-shadow: 0 0 15px rgba(59, 130, 246, 0.6), inset 0 0 5px rgba(59, 130, 246, 0.2);
             border: 2px solid #3b82f6; /* Accent border for definition */
        }

        /* 4. Logo Animation */
        @keyframes pulse-shadow {
            0% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0.5); }
            70% { box-shadow: 0 0 0 10px rgba(79, 70, 229, 0); }
            100% { box-shadow: 0 0 0 0 rgba(79, 70, 229, 0); }
        }

        .logo-pulse:hover .logo-icon {
            animation: pulse-shadow 1.5s infinite;
        }
    </style>

    <!-- Laravel/Vite/Livewire Directives - Preserved as requested -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-primary-50 font-sans text-dark-slate antialiased overflow-x-hidden">

    <!-- Backdrop for Mobile Sidebar -->
    <div id="backdrop" onclick="toggleSidebar()"></div>

    <div class="min-h-screen flex w-full">
        <!-- Sidebar: Now WIDER (w-72) and controlled by JS on mobile -->
        <aside id="sidebar" class="w-72 bg-white border-l border-primary-100 flex flex-col z-50 shadow-2xl shadow-primary-700/10 md:static md:flex-shrink-0">

            <!-- Logo Section (Bigger and bolder) -->
            <div class="h-20 flex items-center px-6 border-b border-primary-200">
                <div class="flex items-center gap-4 smooth-transition hover:scale-[1.03] logo-pulse cursor-pointer">
                    <div class="w-12 h-12 bg-primary-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-primary-700/50 logo-icon">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black text-primary-900">لوحة أحمد بيك</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center px-3 py-3 text-base font-bold rounded-xl smooth-transition {{ request()->routeIs('admin.dashboard') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.dashboard') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    الرئيسية
                </a>

                <!-- Inventory Section -->
                <div class="pt-6 pb-2">
                    <p class="px-3 text-xs font-black text-primary-700 uppercase tracking-wider">إدارة المخزون</p>
                </div>

                <a href="{{ route('admin.categories') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.categories') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.categories') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    الأصناف
                </a>

                <a href="{{ route('admin.products') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.products') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.products') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    المنتجات
                </a>

                <a href="{{ route('admin.companies') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.companies') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.companies') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    الشركات
                </a>

                <!-- Sales Section -->
                <div class="pt-6 pb-2">
                    <p class="px-3 text-xs font-black text-primary-700 uppercase tracking-wider">المبيعات والمالية</p>
                </div>

                <a href="{{ route('admin.customers') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.customers') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.customers') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    الزبائن
                </a>

                <a href="{{ route('admin.orders') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.orders') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.orders') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    الطلبات
                </a>

                <a href="{{ route('admin.invoices') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.invoices') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.invoices') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    فواتير الشراء
                </a>

                <a href="{{ route('admin.sales') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.sales') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.sales') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    فواتير المبيعات
                </a>

                <!-- System Section -->
                <div class="pt-6 pb-2">
                    <p class="px-3 text-xs font-black text-primary-700 uppercase tracking-wider">النظام</p>
                </div>

                <a href="{{ route('admin.settings') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.settings') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.settings') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    الإعدادات
                </a>

                <a href="{{ route('admin.users') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.users') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.users') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    المستخدمين
                </a>

                <!-- Reporting Section -->
                <div class="pt-6 pb-2">
                    <p class="px-3 text-xs font-black text-primary-700 uppercase tracking-wider">التقارير</p>
                </div>

                {{-- <a href="{{ route('admin.reports.financial') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.reports.financial') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.reports.financial') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    التقارير المالية
                </a>

                <a href="{{ route('admin.reports.inventory') }}" class="nav-link flex items-center px-3 py-3 text-base font-medium rounded-xl smooth-transition {{ request()->routeIs('admin.reports.inventory') ? 'bg-accent/10 text-accent active-link' : 'text-slate-600 hover:bg-primary-100 hover:text-primary-700' }}">
                    <svg class="ml-3 h-5 w-5 {{ request()->routeIs('admin.reports.inventory') ? 'text-accent' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0h6" />
                    </svg>
                    تقارير المخزون
                </a> --}}
                <!-- End of all original and restored links -->

            </nav>

            <!-- Logout Section -->
            <div class="p-4 border-t border-primary-100">
                <!-- Original Logout Form - Preserved -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link flex items-center w-full px-3 py-3 text-base font-medium text-slate-600 rounded-xl smooth-transition hover:bg-red-50 hover:text-red-600 hover:scale-[1.02] hover:shadow-lg hover:shadow-red-200/50 hover:border hover:border-red-100">
                        <svg class="ml-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content w-full">
            <!-- Header (Sticky, Elevated) -->
            <header class="main-header h-16 bg-white border-b border-primary-200 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-40 shadow-sm">

                <!-- Mobile Menu Button (Hamburger) -->
                <button onclick="toggleSidebar()" class="md:hidden text-primary-700 hover:text-primary-900 smooth-transition p-2 rounded-lg hover:bg-primary-100 focus:outline-none">
                    <!-- Hamburger Icon -->
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <h1 class="text-xl font-extrabold text-dark-slate text-base sm:text-xl truncate">
                    {{ $header ?? 'نظرة عامة على النظام' }}
                </h1>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 sm:gap-3 smooth-transition hover:scale-[1.05] cursor-pointer">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-bold text-dark-slate">{{ auth()->user()->name ?? 'أحمد بيك' }}</p>
                            <p class="text-xs text-slate-500">مهندس برمجيات (Backend)</p>
                        </div>
                        <div class="h-10 w-10 sm:h-12 sm:w-12 rounded-full bg-accent/20 flex items-center justify-center text-accent font-black border-2 border-accent/40 ring-2 ring-accent/50 shadow-inner smooth-transition hover:ring-accent/70 hover:shadow-lg hover:shadow-accent/50 text-base">
                            <!-- Displaying the first letter of the name -->
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area (Fully responsive using fluid padding) -->
            <div class="p-4 sm:p-6 w-full">
                <!-- Card Container for Content -->
                <div class="bg-white p-4 sm:p-8 rounded-3xl shadow-2xl shadow-primary-200/50 border-t-8 border-accent smooth-transition hover:shadow-primary-300/70 hover:translate-y-[-1px] min-h-[calc(100vh-8rem)] w-full">
                    <!-- This slot contains your actual page content -->
                    <h2 class="text-2xl font-bold text-dark-slate mb-4 border-b pb-2 border-primary-100">{{ $slot }}</h2>
                    <p class="text-slate-600 leading-relaxed">
                        أهلاً بك يا أحمد بيك، في لوحة التحكم بتصميمها الجديد الذي يجمع بين فخامة الأزرق الملكي وحيوية الألوان الزاهية.
                        تم تحسين التجاوب ليشمل الأجهزة اللوحية (الآيباد) بجميع أحجامها، وتم زيادة عرض الشريط الجانبي ليكون أكثر اتساعاً وجاذبية.
                        كما تم تطبيق تأثيرات حية ومبهجة على الروابط النشطة.
                    </p>
                </div>
            </div>
        </main>
    </div>

    <!-- JavaScript for Sidebar Toggle (Crucial for mobile experience) -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('backdrop');

        // Function to toggle the sidebar's open state
        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('open');
            if (isOpen) {
                // Close sidebar
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
            } else {
                // Open sidebar
                sidebar.classList.add('open');
                backdrop.classList.add('open');
            }
        }

        // Close sidebar when clicking outside (on the backdrop)
        // This is handled by the onclick on the backdrop element itself.

        // Ensure sidebar is positioned correctly on load for desktop/tablet devices
        window.addEventListener('load', () => {
            // Check if viewport is >= 768px (md: breakpoint)
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('open');
                backdrop.classList.remove('open');
            }
        });

    </script>

    <!-- Livewire Scripts - Preserved as requested -->
    @livewireScripts
</body>
</html>
