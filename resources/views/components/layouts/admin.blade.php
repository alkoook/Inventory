<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>

    @livewireStyles

    {{-- TomSelect CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">

    @stack('styles')>
    
    <style>
        {{--  @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');  --}}
        body {
            font-family: 'Cairo', sans-serif;
        }
        
        /* 1. Base Transitions */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* 2. Sidebar Styling & Visibility */
        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 50;
            width: 18rem; /* w-72 */
            transform: translateX(100%); /* Initially hide off-screen (Mobile) */
            transition: transform 0.3s ease-in-out;
            /* White/Light Blue Gradient for the new theme */
            background-image: linear-gradient(to bottom, #ffffff, #f7faff);
            box-shadow: -8px 0 20px rgba(0, 0, 0, 0.05); /* Soft shadow on the left */
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

        /* 3. Tablet (md) and Desktop (lg) specific sidebar visibility and main content spacing */
        @media (min-width: 768px) {
            #sidebar {
                transform: translateX(0); /* Always visible on Tablet/Desktop */
            }
            .main-content {
                margin-right: 18rem; /* Reserve space for the WIDER sidebar (18rem) */
            }
            .topbar-margin {
                /* Ensures the top bar shifts left correctly on desktop */
                margin-right: 18rem; 
            }
        }
        
        /* 4. Enhanced Navigation Links - Lively Effect */
        .nav-link {
            position: relative;
            overflow: hidden;
            z-index: 10;
        }

        .nav-link:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.2);
        }

        /* Style for the active link: vibrant blue fill with a glow */
        .active-link {
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            border: 1px solid #3b82f6; 
        }
    </style>

    @livewireStyles

    {{-- TomSelect CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">

    @stack('styles')

</head>
<body class="bg-primary-50 text-dark-text antialiased">
    <div class="min-h-screen">
        <!-- Backdrop for mobile sidebar -->
        <div id="backdrop" onclick="toggleSidebar()"></div>

        <!-- Sidebar (RTL: fixed right) -->
        <aside id="sidebar" class="fixed right-0 top-0 h-screen w-72 p-0 smooth-transition">
            <!-- Logo Area -->
            <div class="p-6 border-b border-primary-100 flex justify-center logo-pulse">
                <div class="flex items-center gap-3">
                    <div class="logo-icon w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-700 to-primary-600 shadow-xl flex items-center justify-center text-white text-2xl font-black smooth-transition" style="box-shadow: 0 4px 20px rgba(59, 130, 246, 0.4);">
                        <span style="transform: rotate(15deg);">💎</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-dark-text">لوحة التحكم</h1>
                        <p class="text-xs text-gray-500">نظام إدارة المخزون</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-180px)]">
                <!-- 
                    NOTE: The first link is set to active (Dashboard) for demonstration. 
                    I am using static '#' links instead of Blade routes.
                -->

                <!-- الرئيسية (Dashboard) -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition active-link bg-primary-100 text-primary-700 font-semibold">
                    <div class="p-2 rounded-lg bg-primary-700/10 text-primary-700">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <span>الرئيسية</span>
                </a>

                <!-- الإدارة (Management) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">إدارة المخزون</p>
                </div>

                <!-- الأصناف (Categories) -->
                <a href="{{ route('admin.categories.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="font-medium">الأصناف</span>
                </a>

                <!-- المنتجات (Products) -->
                <a href="{{ route('admin.products.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="font-medium">المنتجات</span>
                </a>

                <!-- المخزون (Inventory) -->
                <a href="{{ route('admin.inventory.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="font-medium">المخزون</span>
                </a>

                <!-- الشركات (Companies) -->
                <a href="{{ route('admin.companies.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-medium">الشركات</span>
                </a>

                <!-- المبيعات والعملاء (Sales & Customers) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">المبيعات والعملاء</p>
                </div>

           
                <!-- الطلبات (Orders) -->
                <a href="{{ route('admin.orders.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <span class="font-medium">الطلبات</span>
                </a>

                <!-- فواتير البيع (Sales Invoices) -->
                <a href="{{ route('admin.sales-invoices.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">فواتير البيع</span>
                </a>

                <!-- فواتير الشراء (Purchase Invoices) -->
                <a href="{{ route('admin.purchase-invoices.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">فواتير الشراء</span>
                </a>

                <!-- الإعدادات (Settings) Section -->
                <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">النظام</p>
                </div>

                <!-- الإعدادات (Settings) -->
                <a href="{{ route('admin.settings') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">الإعدادات</span>
                </a>
                
                <!-- المستخدمين (Users) -->
                <a href="{{ route('admin.users.index') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-primary-100/50">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-600 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">المستخدمين</span>
                </a>


                    <div class="px-4 pt-6 pb-2">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">تسجيل الخروج</p>
                </div>
              <form action ="{{ route('admin.logout') }}" method="POST"
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl smooth-transition text-dark-text hover:bg-red-100/50">
                @csrf

                    <div class="p-2 rounded-lg bg-gray-100 text-red-600 group-hover:bg-red-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
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
            <div class="absolute bottom-0 right-0 left-0 p-4 border-t border-primary-100">
                <a href="{{ route('client.catalog') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-dark-text hover:bg-primary-100/50 transition-all group">
                    <div class="p-2 rounded-lg bg-gray-100 text-primary-700 group-hover:bg-primary-200/50">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <span class="font-medium">عرض الموقع</span>
                </a>
            </div>
        </aside>

        <!-- Main Content Wrapper (Used for desktop margin) -->
        <div class="main-content">
            <!-- Top Bar (Sticky header) -->
            <header class="md:hidden topbar-margin sticky top-0 bg-white/95 backdrop-blur-sm border-b border-gray-100 shadow-sm" style="z-index: 30;">
                <div class="px-6 py-4 flex items-center justify-between">
                    <!-- Mobile Menu Button (Only visible on screens < md) -->
                    <button class="md:hidden p-2 rounded-xl text-dark-text hover:bg-gray-100 transition-colors" onclick="toggleSidebar()">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    
                </div>
            </header>

            <!-- Page Content Placeholder -->
            <main class="p-6 min-h-screen">
                {{ $slot }}
            </main>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        function initTomSelects() {

            // Products
            document.querySelectorAll('.product-select').forEach((el) => {
                if (!el.tomselect) {
                    new TomSelect(el, {
                        placeholder: "ابحث عن منتج...",
                        maxItems: 1,
                        allowEmptyOption: true,
                    });
                }
            });

            // Customers
            document.querySelectorAll('.customer-select').forEach((el) => {
                if (!el.tomselect) {
                    new TomSelect(el, {
                        placeholder: "ابحث عن زبون...",
                        maxItems: 1,
                        allowEmptyOption: true,
                    });
                }
            });
        }

        document.addEventListener('livewire:load', initTomSelects);
        document.addEventListener('livewire:update', initTomSelects);
    </script>

    @livewireScripts

    @stack('scripts')
    <script>
        // Get references to the sidebar and backdrop elements
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('backdrop');
        const mainContent = document.querySelector('.main-content');
        const topbar = document.querySelector('.topbar-margin');

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

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        // Using 'Cairo' as per the style block below for Arabic support
                        sans: ['Cairo', 'Inter', 'Tahoma', 'Arial', 'sans-serif'],
                    },
                    colors: {
                        // Light primary colors for backgrounds
                        'primary': {
                            50: '#f7faff', // Very light background
                            100: '#e0e7ff',
                            600: '#4f46e5', // Rich Blue (Indigo) - secondary accent
                            700: '#3b82f6', // Electric Blue - main active/accent color
                            900: '#1e3a8a', // Deep Blue for text/contrast
                        },
                        'accent': '#3b82f6', // Bright, Electric Blue for highlights/vibrancy
                        'dark-text': '#1e293b', // Slate for main text
                    }
                }
            }
        }

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