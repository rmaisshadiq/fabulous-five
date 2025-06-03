{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'Kendaraan')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Pilihan Kendaraan Kami</h1>
        
        {{-- Include styles --}}
        @include('kendaraan.car.styles')
        
        {{-- Include slider container (yang sudah include vehicle-card di dalamnya) --}}
        @include('kendaraan.car.vehicle-slider-container')
        
        {{-- Include JavaScript --}}
        @include('kendaraan.car.vehicle-slider')
    </div>
    <script>
        
    </script>
@endsection