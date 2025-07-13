@extends('layouts.main')

@section('title', 'Detail pemesanan')

@section('content')
                @include('artikel.hero-section')
    <section class="py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @include('artikel.artikel-header')
                @include('artikel.artikel-body')
        </div>
    </section>
@endsection

