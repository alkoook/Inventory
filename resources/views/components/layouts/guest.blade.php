<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'نظام إدارة المخزون' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-gray-100 antialiased min-h-screen" style="background-image: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(239, 68, 68, 0.08) 0%, transparent 50%);">
    <div class="min-h-screen flex items-center justify-center p-4">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
