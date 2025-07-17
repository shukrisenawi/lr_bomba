<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100 scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <title>Soal Selidik Responden</title>
    <link rel="icon" href="../img/icon.ico" type="image/x-icon">
</head>
<body class="h-full">
<div class="min-h-full" style="background-image: url(../img/background.webp);background-attachment: fixed; background-size: cover; background-position: center;">
    <div class="max-w-4xl mx-auto p-6 opacity-95">
        <div class="max-w-4xl mx-auto p-6">

        <div class="bg-white shadow-lg rounded-lg p-8">
            {{ $slot }}
        </div>
        </div>
    </div>
  </div>
<x-footer></x-footer>
</body>
</html>