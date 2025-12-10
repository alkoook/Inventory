<!DOCTYPE html>
<html lang="ar" dir="rtl" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'نظام إدارة المخزون' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        html, body {
            background-color: #020617 !important;
            color: #f1f5f9 !important;
        }
        * {
            color-scheme: dark;
        }
    </style>
</head>
<body class="bg-slate-950 text-gray-100 antialiased min-h-screen" style="background-color: #020617;">
    <div class="min-h-screen flex items-center justify-center p-4" style="background-color: #020617;">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
