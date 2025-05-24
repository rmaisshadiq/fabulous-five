@extends('layouts.main')

@section('title', 'Landing Page')

@section('content')
    @include('landingpage.section')
    @include('landingpage.chosecar')
    @include('landingpage.articles')
    @include('landingpage.unggulan')
    @include('landingpage.syaratKetentuan')
    @include('landingpage.FAQ')
    @include('landingpage.location')
    @include('landingpage.appeal')
@endsection