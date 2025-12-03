<!DOCTYPE html>
<html lang="ar" dir="rtl">
@php
    // تم الحفاظ على صيغة Blade/PHP لتناسب بيئتك
    use App\Models\Setting;
@endphp
<head>
    <meta charset="UTF-8">
<<<<<<< HEAD
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
=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'متجر المخزون' }}</title>
    <!-- تم إزالة تضمينات vite/livewire لغرض العرض في بيئة Immersive، ولكن يجب إعادتها في ملفك الأصلي -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <!-- @livewireStyles -->

    <!-- استخدام Tailwind CDN وتحسينات جمالية (ألوان مبهجة) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }

        /* لون أساسي مبهج (أخضر زاهي) */
        .color-primary {
            background-color: #10B981; /* Emerald 500 */
        }
        .text-primary {
            color: #10B981;
        }
        .hover\:text-primary:hover {
            color: #10B981;
        }

        /* تأثير الخط السفلي الأنيق للروابط في شريط التنقل العلوي */
        .nav-link {
            position: relative;
            padding-bottom: 8px;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: 0;
            right: 0;
            background-color: #10B981;
            transition: width 0.3s ease-in-out;
            border-radius: 9999px;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
            left: 0;
            right: auto;
        }

        /* ستايل القائمة الجانبية المخفية للجوال (من اليمين لليسار) */
        #mobile-sidebar {
            /* إخفاء افتراضي على الشاشات الكبيرة */
            transform: translateX(100%);
            transition: transform 0.3s ease-out, visibility 0.3s;
            visibility: hidden;
        }
        #mobile-sidebar.open {
            transform: translateX(0);
            visibility: visible;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col">

        <!-- شريط التنقل العلوي (Navbar) - يظهر على اللابتوب فقط -->
        <nav class="bg-white/95 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 shadow-lg hidden md:block">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">

                    <!-- الشعار والروابط (Navbar) -->
                    <div class="flex items-center gap-12">
                        <!-- الشعار -->
                        {{-- <a href="{{ route('client.catalog') }}" class="flex items-center gap-3 group transform hover:scale-[1.03] transition-transform duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-[#10B981] to-green-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-teal-200 group-hover:shadow-teal-300 transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="font-bold text-2xl text-slate-900 tracking-tight">متجر<span class="text-primary">المخزون</span></span>
                        </a> --}}

                        <!-- روابط سطح المكتب -->
                        <div class="flex items-center gap-8 h-full">
                            <a href="{{ route('client.catalog') }}" class="nav-link text-base font-bold text-slate-700 hover:text-primary transition-colors active">الرئيسية</a>
                            <a href="{{ route('client.catalog') }}" class="nav-link text-base font-bold text-slate-700 hover:text-primary transition-colors">المنتجات</a>
                            <a href="{{ route('client.categories') }}" class="nav-link text-base font-bold text-slate-700 hover:text-primary transition-colors">الأصناف</a>
                            <a href="{{ route('client.companies') }}" class="nav-link text-base font-bold text-slate-700 hover:text-primary transition-colors">الشركات</a>
                            <a href="{{ route('client.about-us') }}" class="nav-link text-base font-bold text-slate-700 hover:text-primary transition-colors">من نحن</a>
                            <a href="{{ route('client.contact-us') }}" class="nav-link text-base font-bold text-slate-700 hover:text-primary transition-colors">اتصل بنا</a>
                        </div>
                    </div>

                    <!-- أيقونات إضافية (على اليمين في RTL) -->
                    <div class="flex items-center gap-4">
                        <button class="p-2 rounded-full text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors transform hover:scale-110" aria-label="Search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>
                            </svg>
                        </button>
                        <button class="relative p-2 rounded-full text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors transform hover:scale-110" aria-label="Cart">
                            <!-- livewire:client.cart-counter Placeholder -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart">
                                <circle cx="8" cy="20" r="1"/><circle cx="19" cy="20" r="1"/><path d="M2.5 2.5h2.43a2 2 0 0 1 1.8 1.16l2.16 4.33a2 2 0 0 0 1.8 1.16h7.33a2 2 0 0 0 1.8-1.16l2.16-4.33a2 2 0 0 0 1.8-1.16h2.43"/><path d="m10 13 2 3H10"/>
                            </svg>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
                        </button>
                    </div>
                </div>
            </header>

<<<<<<< HEAD
            <!-- Page Content -->
            <main class="p-6 min-h-screen">
                {{ $slot }}
            </main>
        </div>
=======
        <!-- شريط تنقل علوي مبسط للجوال (يحتوي فقط على الشعار وزر القائمة) -->
        <header class="bg-white/95 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 shadow-lg md:hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center h-16">
                    <!-- الشعار -->
                    <a href="{{ route('client.catalog') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-[#10B981] rounded-lg flex items-center justify-center text-white shadow-md">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-slate-900">متجر<span class="text-primary">المخزون</span></span>
                    </a>

                    <!-- زر الهامبرغر لفتح القائمة الجانبية -->
                    <button id="sidebar-toggle" class="p-2 rounded-full text-slate-600 hover:bg-slate-100 hover:text-primary transition-colors transform hover:scale-110" aria-label="Toggle menu">
                        <svg id="menu-icon" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                </div>
            </div>
        </header>

        <!-- القائمة الجانبية (Sidebar) - تظهر كدرج على الجوال والتابلت -->
        <div id="mobile-sidebar" class="fixed top-0 right-0 h-full w-64 bg-white shadow-2xl z-50 p-6 flex flex-col md:hidden">

            <!-- رأس القائمة (إغلاق) -->
            <div class="flex justify-between items-center mb-8 pb-4 border-b border-slate-100">
                <h3 class="font-bold text-lg text-primary">قائمة المتجر</h3>
                <button id="sidebar-close" class="p-2 rounded-full text-slate-600 hover:bg-slate-100 hover:text-red-500 transition-colors" aria-label="Close menu">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <!-- روابط القائمة -->
            <ul class="space-y-2 text-base font-medium flex-grow">
                <li><a href="{{ route('client.catalog') }}" class="block px-4 py-3 text-slate-700 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors active:bg-primary/20">الرئيسية</a></li>
                <li><a href="{{ route('client.catalog') }}" class="block px-4 py-3 text-slate-700 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors">المنتجات</a></li>
                <li><a href="{{ route('client.categories') }}" class="block px-4 py-3 text-slate-700 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors">الأصناف</a></li>
                <li><a href="{{ route('client.companies') }}" class="block px-4 py-3 text-slate-700 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors">الشركات</a></li>
                <li><a href="{{ route('client.about-us') }}" class="block px-4 py-3 text-slate-700 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors">من نحن</a></li>
                <li><a href="{{ route('client.contact-us') }}" class="block px-4 py-3 text-slate-700 hover:bg-primary/10 hover:text-primary rounded-lg transition-colors">اتصل بنا</a></li>
            </ul>

            <!-- قسم السلة في الأسفل (مثلاً) -->
            <div class="mt-auto pt-4 border-t border-slate-100">
                <button class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 text-slate-700 hover:bg-slate-200 rounded-xl transition-colors font-bold">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l3 11h9l3-11h2L21 3H3zM7 21h10M10 18h4"></path></svg>
                    سلة التسوق
                </button>
            </div>
        </div>

        <!-- طبقة التعتيم عند فتح القائمة الجانبية -->
        <div id="overlay" class="fixed inset-0 bg-black/50 z-40 md:hidden opacity-0 invisible transition-opacity duration-300"></div>


        <!-- المحتوى الرئيسي -->
        <main class="flex-grow pt-6">
            {{ $slot }}
        </main>

        <!-- التذييل (Footer) -->
        <footer class="bg-white border-t border-slate-200 mt-auto">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <!-- تم الاحتفاظ ببقية الهيكل الأصلي للفوتر مع تحسين الألوان -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 color-primary rounded-lg flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="font-bold text-xl text-slate-900">متجر المخزون</span>
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-md">
                            {{ Setting::get('about_us', 'نظام متكامل لإدارة المخزون والمبيعات، يوفر لك تجربة تسوق سلسة وسهلة.') }}
                        </p>
                        <!-- Social Media Icons (Blade syntax preserved) -->
                        <div class="flex items-center gap-4 mt-6">
                            @if($fb = Setting::get('facebook_url'))
                                <a href="{{ $fb }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-primary/20 hover:text-primary transition-colors" aria-label="Facebook">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($tw = Setting::get('twitter_url'))
                                <a href="{{ $tw }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-primary/20 hover:text-primary transition-colors" aria-label="Twitter">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                            @endif
                            @if($in = Setting::get('instagram_url'))
                                <a href="{{ $in }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-primary/20 hover:text-primary transition-colors" aria-label="Instagram">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($li = Setting::get('linkedin_url'))
                                <a href="{{ $li }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-primary/20 hover:text-primary transition-colors" aria-label="LinkedIn">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900 mb-4">روابط سريعة</h3>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li><a href="{{ route('client.catalog') }}" class="hover:text-primary transition-colors">الرئيسية</a></li>
                            <li><a href="{{ route('client.categories') }}" class="hover:text-primary transition-colors">الأصناف</a></li>
                            <li><a href="{{ route('client.companies') }}" class="hover:text-primary transition-colors">الشركات</a></li>
                            <li><a href="{{ route('client.about-us') }}" class="hover:text-primary transition-colors">من نحن</a></li>
                            <li><a href="{{ route('client.contact-us') }}" class="hover:text-primary transition-colors">اتصل بنا</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900 mb-4">تواصل معنا</h3>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ Setting::get('site_email', 'support@inventory.com') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ Setting::get('site_phone', '+963 912 345 678') }}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-slate-100 mt-12 pt-8 text-center text-sm text-slate-400">
                    &copy; {{ date('Y') }} متجر المخزون. جميع الحقوق محفوظة.
                </div>
            </div>
        </footer>
>>>>>>> 07d468d8af2e220903f1160b2f1d5d84afb5fd1d
    </div>

    <!-- Livewire Scripts Placeholder -->
    <!-- @livewireScripts -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleButton = document.getElementById('sidebar-toggle');
            const closeButton = document.getElementById('sidebar-close');
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('overlay');

            // وظيفة فتح القائمة الجانبية
            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.remove('invisible', 'opacity-0');
                overlay.classList.add('visible', 'opacity-100');
                // لمنع التمرير (Scrolling) في الخلفية عند فتح القائمة
                document.body.style.overflow = 'hidden';
            }

            // وظيفة إغلاق القائمة الجانبية
            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('visible', 'opacity-100');
                overlay.classList.add('invisible', 'opacity-0');
                // استعادة التمرير (Scrolling)
                document.body.style.overflow = 'auto';
            }

            // ربط الأزرار بالوظائف
            if (toggleButton) {
                toggleButton.addEventListener('click', openSidebar);
            }
            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }
            if (overlay) {
                overlay.addEventListener('click', closeSidebar);
            }
        });
    </script>
</body>
</html>
