<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Models\Vehicle;


Route::get('/', function () {
    $articles = Article::take(6)->get(); // Misalnya tampilkan 5 artikel saja
    return view('LandingPage.homePage', compact('articles'));
})->name('home');

Route::get('/car', function () {
    $vehicles = Vehicle::where('status', 'active')->get(); // ambil kendaraan yang aktif
    return view('kendaraan.car.mainPageMobil', compact('vehicles'));
})->name('kendaraan');

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


Route::get('/Detail-Pemesanan', function () {
    return view('Detail-Pemesanan.main-page');
})->name('detail-pemesanan');

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    Route::get('/form-pemesanan/main-page/{id}', function ($id) {
        $vehicles = Vehicle::findOrFail($id);
        return view('form-pemesanan.main-page', compact('vehicles'));
    })->name('form.pemesanan');
    
    //  Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
        Route::patch('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

        Route::post('/customer/orders', [OrderController::class, 'store'])
     ->name('customer.orders.store');
    
});



require __DIR__ . '/auth.php';



