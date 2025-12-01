<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Inventory System' }}</title>
    @livewireStyles
</head>
<body>
    <div class="min-h-screen bg-gray-100">
        {{ $slot }}
    </div>

    @livewireScripts
</body>
</html>
