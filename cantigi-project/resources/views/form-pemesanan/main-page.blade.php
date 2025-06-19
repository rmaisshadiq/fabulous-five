@extends('layouts.main')

@section('title', 'Create New Order')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Form Rental Kendaraan</h1>

            {{--  Pesan --}}
            @include('form-pemesanan.pesan')

            <form action="{{ route('orders.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Selected Vehicle --}}
                @include('form-pemesanan.nama-harga-rental')
                
                {{-- Booking Dates --}}
                @include('form-pemesanan.tanggal-pesan')

                {{-- Booking Times --}}
                @include('form-pemesanan.jam-pesan')

                {{-- Drop Address --}}
                @include('form-pemesanan.lokasi')

                {{-- Tombol --}}
                @include('form-pemesanan.buton-booking')
            </form>
        </div>
    </div>
</div>
@endsection