<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Jabatan Bomba dan Penyelamat')</title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    @stack('styles')
    <link rel="icon" href="../img/icon.ico" type="image/x-icon">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        {{-- @include('layouts.navigation') --}}

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="min-h-screen"
            style="background-image: url({{ asset('img/background.webp') }});background-attachment: fixed; background-size: cover; background-position: center;">
            <div class="flex justify-center m-auto p-2 sm:p-10">
                <div class="w-full sm:w-[800px] bg-white rounded-3xl p-5 sm:p-10 block text-center">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
