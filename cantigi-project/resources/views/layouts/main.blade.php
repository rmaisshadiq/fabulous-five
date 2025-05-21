<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cantigi Tours</title>
    
    {{-- Tailwind dari CDN masih bisa dipakai, tapi disarankan pakai Vite jika kamu compile Tailwind --}}
    {{-- Jika sudah pakai Vite dan Tailwind, hilangkan CDN tailwind dan pakai ini: --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        body {
            font-family: 'roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-white text-gray-800">
    @include('layouts/header')

    <main class="flex-shrink-0">
        <div class="container">
            @yield('content')
        </div>
    </main>

    @include('layouts/footer')

    {{-- Jika kamu ingin meletakkan script di akhir body juga bisa --}}
    {{-- @vite('resources/js/app.js') --}}
</body>

</html>
