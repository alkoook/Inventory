<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'متجر المخزون' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white border-b border-slate-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('client.catalog') }}" class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-white font-bold">
                                M
                            </div>
                            <span class="font-bold text-lg text-slate-800">متجر المخزون</span>
                        </a>
                        <div class="hidden md:mr-8 md:flex md:gap-4">
                            <a href="{{ route('client.catalog') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('client.catalog') ? 'text-slate-800' : 'text-slate-600 hover:text-slate-800' }}">
                                الرئيسية
                            </a>
                            <a href="{{ route('client.companies') }}" class="px-3 py-2 text-sm font-medium {{ request()->routeIs('client.companies*') ? 'text-slate-800' : 'text-slate-600 hover:text-slate-800' }}">
                                الشركات
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('client.card') }}" class="relative p-2">
                            <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">0</span>
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
        <footer class="bg-slate-800 border-t border-slate-700 mt-auto">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-slate-400">
                    &copy; {{ date('Y') }} متجر المخزون. جميع الحقوق محفوظة.
                </p>
            </div>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
