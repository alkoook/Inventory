<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'متجر المخزون' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Cairo', sans-serif;
        }
        
        /* 1. Base Transitions - Smooth with 3D */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
        }
        
        /* 3D Transform Utilities */
        .transform-3d {
            transform-style: preserve-3d;
            perspective: 1000px;
        }
        
        .hover-3d:hover {
            transform: translateZ(20px) rotateY(2deg);
        }

        /* 2. Sidebar Styling & Visibility - Clean & Modern */
        #sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            right: 0;
            z-index: 50;
            width: 18rem; /* w-72 */
            transform: translateX(100%);
            transform-origin: right center;
            transition: transform 0.3s ease-out;
            background: #ffffff;
            box-shadow: -2px 0 20px rgba(0, 0, 0, 0.08);
            border-left: 1px solid #e5e7eb;
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
            background-color: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(2px);
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
        
        /* 4. Navigation Links - Clean & Smooth with 3D */
        .nav-link {
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
        }

        .nav-link:hover {
            background: #f3f4f6;
            transform: translateX(-4px) translateZ(8px) rotateY(2deg);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Style for the active link */
        .active-link {
            background: #e5e7eb;
            border-right: 3px solid #3b82f6;
            transform: translateZ(8px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .group:hover .group-hover\:bg-indigo-50 {
            background-color: #eef2ff;
        }
        
        .group:hover .group-hover\:text-indigo-600 {
            color: #4f46e5;
        }
        
        /* Logo styling - Simple & Clean with 3D */
        .logo-icon {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            background: #3b82f6;
        }

        .logo-icon:hover {
            transform: scale(1.1) rotateY(8deg) rotateX(5deg) translateZ(15px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
        }
        
        /* 3D Card Effect */
        .card-3d {
            transform-style: preserve-3d;
            transition: transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.5s ease;
            perspective: 1000px;
        }
        
        .card-3d:hover {
            transform: translateY(-10px) rotateX(5deg) rotateY(-3deg) translateZ(20px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25), 0 0 30px rgba(59, 130, 246, 0.2);
        }
        
        /* Hide scrollbar completely */
        nav {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }
        
        nav::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }

        /* Page fade in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-content {
            animation: fadeIn 0.4s ease-out;
            transform-style: preserve-3d;
        }
        
        /* Enhanced 3D Animations */
        @keyframes float3d {
            0%, 100% {
                transform: translateY(0) translateZ(0) rotateY(0deg) rotateX(0deg);
            }
            50% {
                transform: translateY(-15px) translateZ(25px) rotateY(8deg) rotateX(5deg);
            }
        }
        
        @keyframes pulse3d {
            0%, 100% {
                transform: scale(1) translateZ(0);
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }
            50% {
                transform: scale(1.08) translateZ(15px);
                box-shadow: 0 0 25px 15px rgba(59, 130, 246, 0.3);
            }
        }
        
        @keyframes rotate3d {
            0% {
                transform: rotateY(0deg) translateZ(0);
            }
            100% {
                transform: rotateY(360deg) translateZ(0);
            }
        }
        
        .float-3d {
            animation: float3d 4s ease-in-out infinite;
        }
        
        .pulse-3d {
            animation: pulse3d 2s ease-in-out infinite;
        }
        
        .rotate-3d {
            animation: rotate3d 20s linear infinite;
        }
    </style>
    @livewireStyles
</head>
<body class="bg-gray-50 text-slate-900 antialiased">
    <div class="min-h-screen">
        <!-- Backdrop for mobile sidebar -->
        <div id="backdrop" onclick="toggleSidebar()"></div>

        <!-- Sidebar (RTL: fixed right) -->
        <aside id="sidebar" class="fixed right-0 top-0 h-screen w-72 p-0 smooth-transition">
            <!-- Logo Area - Clean & Simple -->
            <div class="p-6 border-b border-blue-200 flex justify-center bg-white">
                <div class="flex items-center gap-3">
                
                    <div>
                        <h1 class="text-xl font-semibold text-slate-800">{{ \App\Models\Setting::get('site_name', 'المتجر') }}</h1>
                        <p class="text-xs text-slate-500">نظام إدارة المخزون</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-180px)]">
                <!-- الرئيسية (Home) -->
                <a href="{{ route('home') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('home') ? 'active-link text-blue-700 font-medium' : 'text-slate-600 hover:text-blue-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('home') ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span>الرئيسية</span>
                </a>

                <!-- الأصناف (Categories) -->
                <a href="{{ route('client.categories') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('client.categories') ? 'active-link text-red-700 font-medium' : 'text-slate-600 hover:text-red-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('client.categories') ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-500 group-hover:bg-red-50 group-hover:text-red-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span>الأصناف</span>
                </a>

                <!-- الشركات (Companies) -->
                <a href="{{ route('client.companies') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('client.companies') || request()->routeIs('client.company.details') ? 'active-link text-blue-700 font-medium' : 'text-slate-600 hover:text-blue-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('client.companies') || request()->routeIs('client.company.details') ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span>الشركات</span>
                </a>

                <!-- المنتجات (Products) -->
                <a href="{{ route('client.catalog') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('client.catalog') || request()->routeIs('client.product.details') ? 'active-link text-blue-700 font-medium' : 'text-slate-600 hover:text-blue-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('client.catalog') || request()->routeIs('client.product.details') ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span>المنتجات</span>
                </a>

                <!-- من نحن (About Us) -->
                <a href="{{ route('client.about-us') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('client.about-us') ? 'active-link text-red-700 font-medium' : 'text-slate-600 hover:text-red-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('client.about-us') ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-500 group-hover:bg-red-50 group-hover:text-red-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span>من نحن</span>
                </a>

                <!-- اتصل بنا (Contact Us) -->
                <a href="{{ route('client.contact-us') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('client.contact-us') ? 'active-link text-red-700 font-medium' : 'text-slate-600 hover:text-red-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('client.contact-us') ? 'bg-red-100 text-red-600' : 'bg-slate-100 text-slate-500 group-hover:bg-red-50 group-hover:text-red-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span>اتصل بنا</span>
                </a>

                <!-- السلة (Cart) -->
                <a href="{{ route('client.card') }}" 
                   class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-all relative {{ request()->routeIs('client.card') ? 'active-link text-blue-700 font-medium' : 'text-slate-600 hover:text-blue-600' }}">
                    <div class="p-2 rounded-lg {{ request()->routeIs('client.card') ? 'bg-blue-100 text-blue-600' : 'bg-slate-100 text-slate-500 group-hover:bg-blue-50 group-hover:text-blue-600' }}">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span>السلة</span>
                </a>

                <!-- تسجيل الخروج/دخول -->
                @auth
                    <form action="{{ route('client.logout') }}" method="POST"
                         class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-slate-600 hover:text-red-600 hover:bg-red-50">
                        @csrf
                        <div class="p-2 rounded-lg bg-red-100 text-red-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <button type="submit" class="font-medium">تسجيل الخروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" 
                       class="nav-link flex items-center gap-3 px-4 py-3 rounded-lg transition-colors text-slate-600 hover:text-blue-600">
                        <div class="p-2 rounded-lg bg-slate-100 text-slate-500">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                        </div>
                        <span>تسجيل دخول</span>
                    </a>
                @endauth
            </nav>

        </aside>

        <!-- Fixed Toggle Button (Top Right Corner) -->
        <button class="fixed top-4 right-4 z-50 p-2.5 rounded-lg bg-white/90 backdrop-blur-sm border-2 border-blue-200 text-slate-700 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-300 transition-all shadow-md hover:shadow-xl hover:scale-110 transform-3d" onclick="toggleSidebar()" id="sidebar-toggle">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="menu-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" id="close-icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Main Content Wrapper (Used for desktop margin) -->
        <div class="main-content">
            <!-- Page Content Placeholder -->
            <main class="min-h-screen" style="background: transparent;">
                {{ $slot }}
            </main>

            <!-- Footer - Clean & Modern -->
            <footer class="bg-white border-t border-slate-200 mt-12 text-slate-700">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                        <!-- About Us -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">من نحن</h3>
                            <p class="text-slate-600 leading-relaxed mb-4">
                                {{ \App\Models\Setting::get('about_us', 'متجرنا يقدم مجموعة واسعة من المنتجات عالية الجودة من أفضل الشركات. نسعى لتقديم أفضل تجربة تسوق لعملائنا الكرام.') }}
                            </p>
                            <div class="space-y-2 text-slate-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ \App\Models\Setting::get('site_email', 'info@store.com') }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    <span>{{ \App\Models\Setting::get('site_phone', '+123 456 7890') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">روابط سريعة</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('client.categories') }}" class="text-slate-600 hover:text-red-600 transition-colors">
                                        الأصناف
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.companies') }}" class="text-slate-600 hover:text-blue-600 transition-colors">
                                        الشركات
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.catalog') }}" class="text-slate-600 hover:text-blue-600 transition-colors">
                                        المنتجات
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.about-us') }}" class="text-slate-600 hover:text-red-600 transition-colors">
                                        من نحن
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('client.contact-us') }}" class="text-slate-600 hover:text-red-600 transition-colors">
                                        اتصل بنا
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Social Media -->
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">تابعنا</h3>
                            <p class="text-slate-600 mb-4">تابعنا على وسائل التواصل الاجتماعي</p>
                            <div class="flex items-center gap-3">
                                @php
                                    $whatsappNumber = \App\Models\Setting::get('whatsapp_number');
                                    $whatsappUrl = $whatsappNumber ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNumber) : null;
                                    $facebookUrl = \App\Models\Setting::get('facebook_url', 'https://facebook.com');
                                    $instagramUrl = \App\Models\Setting::get('instagram_url', 'https://instagram.com');
                                    $twitterUrl = \App\Models\Setting::get('twitter_url', 'https://twitter.com');
                                @endphp
                                @if($whatsappNumber)
                                <a href="{{ $whatsappUrl }}" target="_blank" class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-lg flex items-center justify-center text-white transition-all shadow-sm hover:shadow-md hover:scale-110 transform-3d">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                    </svg>
                                </a>
                                @endif
                                @if($facebookUrl)
                                <a href="{{ $facebookUrl }}" target="_blank" class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 rounded-lg flex items-center justify-center text-white transition-all shadow-sm hover:shadow-md hover:scale-110 transform-3d">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                @endif
                                @if($instagramUrl)
                                <a href="{{ $instagramUrl }}" target="_blank" class="w-10 h-10 bg-gradient-to-br from-pink-500 to-red-500 hover:from-pink-600 hover:to-red-600 rounded-lg flex items-center justify-center text-white transition-all shadow-sm hover:shadow-md hover:scale-110 transform-3d">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                @endif
                                @if($twitterUrl)
                                <a href="{{ $twitterUrl }}" target="_blank" class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-500 hover:from-blue-500 hover:to-blue-600 rounded-lg flex items-center justify-center text-white transition-all shadow-sm hover:shadow-md hover:scale-110 transform-3d">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Copyright -->
                    <div class="border-t border-slate-200 pt-8 mt-8 text-center">
                        <p class="text-slate-500">
                            &copy; {{ date('Y') }} <span class="font-semibold text-blue-600">{{ \App\Models\Setting::get('site_name', 'نظام إدارة المخزون') }}</span>. جميع الحقوق محفوظة.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @livewireScripts

    <script>
        // Get references to the sidebar and backdrop elements
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('backdrop');
        const mainContent = document.querySelector('.main-content');
        const toggleButton = document.getElementById('sidebar-toggle');

        // Function to toggle the sidebar's open state
        function toggleSidebar() {
            const isMobile = window.innerWidth < 768;
            const menuIcon = document.getElementById('menu-icon');
            const closeIcon = document.getElementById('close-icon');
            
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
</body>
</html>
