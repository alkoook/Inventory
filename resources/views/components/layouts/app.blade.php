<!DOCTYPE html>
<html lang="ar" dir="rtl">
@php
    use App\Models\Setting;
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'متجر المخزون' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        .nav-link {
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            right: 0;
            background-color: #2563eb; /* blue-600 */
            transition: width 0.3s ease-in-out;
        }
        .nav-link:hover::after {
            width: 100%;
            left: 0;
            right: auto;
        }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 transition-all duration-300 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <!-- Logo & Links -->
                    <div class="flex items-center gap-12">
                        <a href="{{ route('client.catalog') }}" class="flex items-center gap-3 group transform hover:scale-105 transition-transform duration-300">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200 group-hover:shadow-blue-300 transition-all">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="font-bold text-2xl text-slate-900 tracking-tight">متجر<span class="text-blue-600">المخزون</span></span>
                        </a>

                        <div class="hidden md:flex items-center gap-8">
                            <a href="{{ route('client.catalog') }}" class="nav-link text-base font-medium text-slate-600 hover:text-blue-600 py-2 transition-colors">
                                الرئيسية
                            </a>
                            <a href="{{ route('client.catalog') }}" class="nav-link text-base font-medium text-slate-600 hover:text-blue-600 py-2 transition-colors">
                                المنتجات
                            </a>
                            <a href="{{ route('client.categories') }}" class="nav-link text-base font-medium text-slate-600 hover:text-blue-600 py-2 transition-colors">
                                الأصناف
                            </a>
                            <a href="{{ route('client.companies') }}" class="nav-link text-base font-medium text-slate-600 hover:text-blue-600 py-2 transition-colors">
                                الشركات
                            </a>
                            <a href="{{ route('client.about-us') }}" class="nav-link text-base font-medium text-slate-600 hover:text-blue-600 py-2 transition-colors">
                                من نحن
                            </a>
                            <a href="{{ route('client.contact-us') }}" class="nav-link text-base font-medium text-slate-600 hover:text-blue-600 py-2 transition-colors">
                                اتصل بنا
                            </a>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-6">
                        @auth
                            @if(auth()->user()->role === 'customer')
                                <div class="transform hover:scale-110 transition-transform duration-200">
                                    <livewire:client.cart-counter />
                                </div>
                            @endif

                            <div class="relative group">
                                <button class="flex items-center gap-3 pl-2 pr-4 py-2 rounded-full hover:bg-slate-50 transition-colors">
                                    <div class="text-right hidden sm:block">
                                        <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-slate-500">زبون مميز</p>
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm border-2 border-white shadow-sm group-hover:border-blue-200 transition-all">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                </button>

                                <!-- Dropdown -->
                                {{-- <div class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-red-600 transition-colors">
                                            <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            تسجيل الخروج
                                        </button>
                                    </form>
                                </div> --}}
                            </div>
                        @else
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}" class="text-slate-600 hover:text-blue-600 font-medium transition-colors">
                                    تسجيل الدخول
                                </a>
                                <a href="#" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all transform hover:-translate-y-0.5">
                                    حساب جديد
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow pt-6">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 mt-auto">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <span class="font-bold text-xl text-slate-900">متجر المخزون</span>
                        </div>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-md">
                            {{ Setting::get('about_us', 'نظام متكامل لإدارة المخزون والمبيعات، يوفر لك تجربة تسوق سلسة وسهلة.') }}
                        </p>
                        
                        <!-- Social Media Icons -->
                        <div class="flex items-center gap-4 mt-6">
                            @if($fb = Setting::get('facebook_url'))
                                <a href="{{ $fb }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($tw = Setting::get('twitter_url'))
                                <a href="{{ $tw }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                            @endif
                            @if($in = Setting::get('instagram_url'))
                                <a href="{{ $in }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($li = Setting::get('linkedin_url'))
                                <a href="{{ $li }}" target="_blank" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-100 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                        </div>

                    <div>
                        <h3 class="font-bold text-slate-900 mb-4">روابط سريعة</h3>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li><a href="{{ route('client.catalog') }}" class="hover:text-blue-600 transition-colors">الرئيسية</a></li>
                            <li><a href="{{ route('client.categories') }}" class="hover:text-blue-600 transition-colors">الأصناف</a></li>
                            <li><a href="{{ route('client.companies') }}" class="hover:text-blue-600 transition-colors">الشركات</a></li>
                            <li><a href="{{ route('client.about-us') }}" class="hover:text-blue-600 transition-colors">من نحن</a></li>
                            <li><a href="{{ route('client.contact-us') }}" class="hover:text-blue-600 transition-colors">اتصل بنا</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-bold text-slate-900 mb-4">تواصل معنا</h3>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ Setting::get('site_email', 'support@inventory.com') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
    </div>

    @livewireScripts
</body>
</html>
