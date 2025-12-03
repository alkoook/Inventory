<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'متجر المخزون' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-900 text-white antialiased">
    <!-- Navigation -->
    <nav class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ route('client.catalog') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center text-white text-xl font-bold">
                            M
                        </div>
                        <span class="text-xl font-bold text-white">المتجر</span>
                    </a>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center gap-4">
                        <a href="{{ route('client.catalog') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('client.catalog') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} transition-colors">
                            المنتجات
                        </a>
                        <a href="{{ route('client.companies') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('client.companies') || request()->routeIs('client.company.details') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} transition-colors">
                            الشركات
                        </a>
                        <a href="{{ route('client.about-us') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('client.about') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} transition-colors">
                            من نحن
                        </a>
                        <a href="{{ route('client.contact-us') }}" class="px-4 py-2 rounded-lg {{ request()->routeIs('client.contact') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} transition-colors">
                            تواصل معنا
                        </a>
                    </div>
                </div>

                <!-- Cart -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('client.card') }}" class="relative p-2 rounded-lg {{ request()->routeIs('client.card') ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700' }} transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        @auth
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())
                                    ->where('status', 'draft')
                                    ->first()?->items()->count() ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        @endauth
                    </a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg text-white transition-colors">
                                تسجيل خروج
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg text-white transition-colors">
                            تسجيل دخول
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-400">
                <p>&copy; {{ date('Y') }} نظام إدارة المخزون. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
