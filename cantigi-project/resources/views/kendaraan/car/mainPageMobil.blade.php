@extends('layouts.main')

@section('title', 'Kendaraan')

@section('content')
    @include('kendaraan.car.styles')
    @include('kendaraan.car.listMobil')
    @include('kendaraan.car.paginationControl')
@endsection