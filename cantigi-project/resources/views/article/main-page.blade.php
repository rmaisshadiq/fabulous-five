{{-- resources/views/kendaraan/index.blade.php --}}
@extends('layouts.main')

@section('title', 'article')

@section('content')
    <section class="w-[60rem] mx-auto glass-card mt-[100px] mb-[100px] rounded-3xl p-8 animate-slide-in">



        {{-- nama harga rental --}}
        @include('article.breadecrump')

        {{-- nama harga rental --}}
        @include('article.feature-image')

        {{-- opsi rental --}}
        @include('article.article-meta')

        {{-- tanggal pesan --}}
        @include('article.article-content')

        {{-- lokasi --}}
        @include('article.related-article')

    </section>

    @endsection


