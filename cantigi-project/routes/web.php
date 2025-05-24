<?php

use Illuminate\Support\Facades\Route;
use App\Models\Vehicle;
Route::get('/', function () {
    return view('LandingPage.homePage');
})->name('home');



Route::get('/car', function () {
    $vehicles = Vehicle::where('status', 'active')->get(); // ambil kendaraan yang aktif
    return view('kendaraan.car.mainPageMobil', compact('vehicles'));
})->name('kendaraan');