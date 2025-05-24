@extends('layouts.main')

@section('title', 'Landing Page')

@section('content')
    @include('landingpage.heroImage')
    @include('landingpage.pilihKendaraan')
    @include('landingpage.artikel')
    @include('landingpage.unggulan')
    @include('landingpage.syaratKetentuan')
    @include('landingpage.FAQ')
    @include('landingpage.lokasi')
    @include('landingpage.hubungi')
@endsection