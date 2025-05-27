{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'pemesanan')

@section('content')
    <section class="w-[60rem] glass-card rounded-3xl p-8 animate-slide-in">

        
        {{-- nama harga rental --}}
        @include('form-pemesanan.nama-harga-rental')
        
        {{-- opsi rental --}}
        @include('form-pemesanan.opsi-rental')
        
        {{-- tanggal pesan --}}
        @include('form-pemesanan.tanggal-pesan')

        {{-- lokasi --}}
        @include('form-pemesanan.lokasi')

        {{-- ringkasan harga --}}
        @include('form-pemesanan.ringkasan-harga')

        {{-- buton booking --}}
        @include('form-pemesanan.buton-booking')
        
    </section>
@endsection