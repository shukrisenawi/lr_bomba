<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.min.css">
    <title>@yield('title', 'Jabatan Bomba dan Penyelamat')</title>
    <link rel="icon" href="../img/icon.ico" type="image/x-icon">
</head>

<body class="h-full">
    <div class="min-h-full"
        style="background-image: url({{ asset('img/background.webp') }});background-attachment: fixed; background-size: cover; background-position: center;">
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.all.min.js"></script>
    <x-footer></x-footer>
    @stack('scripts')
</body>

</html>
