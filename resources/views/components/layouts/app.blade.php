<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'نظام إدارة المخزن' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-900 text-gray-100 font-sans antialiased selection:bg-cyan-500 selection:text-white">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-slate-900/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('client.catalog') }}" class="flex-shrink-0 flex items-center gap-2 group">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-cyan-500/20 group-hover:shadow-cyan-500/40 transition-all duration-300 group-hover:scale-105">
                                📦
                            </div>
                            <span class="font-bold text-xl bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400">المخزن</span>
                        </a>
                        <div class="hidden sm:mr-8 sm:flex sm:space-x-8 sm:space-x-reverse">
                            <a href="{{ route('client.catalog') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('client.catalog') ? 'border-cyan-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-700' }}">
                                الرئيسية
                            </a>
                            <a href="{{ route('client.companies') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200 {{ request()->routeIs('client.companies') ? 'border-cyan-500 text-white' : 'border-transparent text-gray-400 hover:text-gray-200 hover:border-gray-700' }}">
                                الشركات
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('client.card') }}" class="relative group p-2 rounded-full hover:bg-slate-800 transition-colors duration-200">
                            <span class="sr-only">السلة</span>
                            <svg class="h-6 w-6 text-gray-400 group-hover:text-cyan-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>
                            <!-- Badge placeholder if needed -->
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-slate-900 border-t border-slate-800 mt-auto">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:order-2 space-x-6 space-x-reverse">
                        <a href="#" class="text-gray-500 hover:text-cyan-400 transition-colors">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                        </a>
                        <a href="#" class="text-gray-500 hover:text-cyan-400 transition-colors">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                        </a>
                    </div>
                    <div class="mt-8 md:mt-0 md:order-1">
                        <p class="text-center text-base text-gray-500">
                            &copy; {{ date('Y') }} نظام إدارة المخزن. جميع الحقوق محفوظة.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>


