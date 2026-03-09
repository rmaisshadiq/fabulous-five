<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Models\Vehicle;

Route::get('/', function () {
    $articles = Article::take(6)->get(); // Misalnya tampilkan 5 artikel saja
    $article = Article::all();
    return view('LandingPage.homePage', compact('articles'));
})->name('home');

Route::get('/car', [VehicleController::class, 'index'])->name('kendaraan');
Route::get('/vehicles/filter', [VehicleController::class, 'filter'])->name('vehicles.filter');

Route::get('/about-us', function () {
    return view('about-us.main-page');
})->name('about-us');

Route::get('/artikel/{id}', function ($id) {
    $article = Article::findOrFail($id);
    return view('artikel.main-page', compact('article'));
})->name('artikel.show');

Route::get('/artikel/{id}', function ($id) {
    $article = Article::findOrFail($id);
    return view('artikel.main-page', compact('article'));
})->name('artikel.detail');

Route::get('/hubungi-kami', function () {
    return view('footer.hubungi-kami');
})->name('hubungi-kami');

Route::get('/kebijakan-privasi', function () {
    return view('footer.kebijakan-privasi');
})->name('kebijakan-privasi');

Route::get('/ketentuan-pengguna', function () {
    return view('footer.ketentuan-pengguna');
})->name('ketentuan-pengguna');

Route::get('/pusat-bantuan', function () {
    return view('footer.pusat-bantuan');
})->name('pusat-bantuan');

Route::get('/syarat-ketentuan', function () {
    return view('footer.syarat-ketentuan');
})->name('syarat-ketentuan');

Route::get('/error', function () {
    return view('errors.general');
})->name('error.general');


    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


require __DIR__ . '/auth.php';
