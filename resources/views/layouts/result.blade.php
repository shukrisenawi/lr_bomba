<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Jabatan Bomba dan Penyelamat')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @stack('styles-result')
    <link rel="icon" href="../img/icon.ico" type="image/x-icon">
</head>

<body class="font-sans antialiased" data-theme="light">
    <main class="min-h-screen"
        style="background-image: url({{ asset('img/background.webp') }});background-attachment: fixed; background-size: cover; background-position: center;">
        @yield('content')
    </main>
    @stack('scripts')
</body>

</html>
