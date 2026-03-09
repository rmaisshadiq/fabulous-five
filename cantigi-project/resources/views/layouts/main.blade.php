<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sewa Mobil & Bus Pariwisata Padang') | Cantigi Tours</title>
    <meta name="description" content="@yield('meta_description', 'Layanan rental mobil lepas kunci dan sewa bus pariwisata terbaik di Padang, Sumatera Barat. Harga murah, armada lengkap, dan pelayanan profesional.')">
    <meta name="keywords" content="@yield('meta_keywords', 'sewa mobil padang, rental mobil padang, sewa bus padang, bus pariwisata padang, sewa mobil lepas kunci padang, rental mobil murah padang, sewa mobil sumatera barat, padang travel, wisata padang, tour padang')">

    <meta property="og:title" content="Cantigi Tours - Solusi Transportasi Anda">
    <meta property="og:description" content="Sewa mobil harian dan bus pariwisata terpercaya di Sumatera Barat.">
    <meta property="og:image" content="{{ asset('images/logo/banner.png') }}"> <meta property="og:url" content="{{ url()->current() }}">
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
    <link rel="icon" href="{{ asset('images/logo/logo.png') }}" type="image/x-icon">
</head>

<body class="bg-white text-gray-800 overflow-x-hidden">
    @include('layouts/header')

    <main class="flex-shrink-0 overflow-x-hidden">
        @yield('content')
    </main>

    @include('layouts/footer')
</body>

</html>
