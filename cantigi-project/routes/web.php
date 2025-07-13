<?php

use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationController;
use App\Models\Article;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Route;
use App\Models\Vehicle;
use App\Http\Controllers\PaymentController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $articles = Article::take(6)->get(); // Misalnya tampilkan 5 artikel saja
    $article = Article::all();
    return view('LandingPage.homePage', compact('articles'));
})->name('home');

Route::get('/car', function () {
    $vehicles = Vehicle::where('status', 'active')->get(); // ambil kendaraan yang aktif
    $orders = Order::all();
    return view('kendaraan.car.mainPageMobil', compact('vehicles'));
})->name('kendaraan');

Route::get('/about-us', function () {
    $orders = Order::all();
    $customers = Customer::all();
    return view('about-us.main-page', compact('orders', 'customers'));
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

Route::get('/feedback', function () {
    $orders = Order::all();
    $customers = Customer::all();
    return view('feedback.main-page', compact('orders', 'customers'));
})->middleware(['auth', 'verified'])->name('feedback');

Route::get('/order-history', function () {
    $orders = Order::with(['driver', 'vehicle'])->get();
    return view('order-history.main-page', compact('orders'));
})->name('order-history');


Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
// Route untuk menyimpan feedback
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/error', function () {
    return view('errors.general');
})->name('error.general');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/verify', [VerificationController::class, 'show'])->name('profile.verify');
        Route::post('/verify', [VerificationController::class, 'store'])->name('profile.verify.store');
    });

    Route::get('/order-history', function () {
        $orders = Order::where('customer_id', Auth::user()->id)->with(['driver', 'vehicle'])->get();
        return view('order-history.main-page', compact('orders'));
    })->name('order-history');

    Route::get('/pemesanan/{id}', [OrderController::class, 'show'])
        ->name('detail-pemesanan');

    Route::get('/pemesanan/{order}/download', [OrderController::class, 'downloadInvoicePdf'])->name('orders.invoice.download');

    Route::get('/form-pemesanan/main-page/{id}', function ($id) {
        $vehicles = Vehicle::findOrFail($id);
        return view('form-pemesanan.main-page', compact('vehicles'));
    })->name('form.pemesanan');

    Route::get('/form-pemesanan', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/pending', [OrderController::class, 'showPending'])->name('orders.pending');

    Route::prefix('payment')->group(function () {
        Route::get('/{id}', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/success/{orderId}', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/qris', [PaymentController::class, 'qrisPayment'])
            ->name('payment.qris');
        Route::post('/qris/complete/{id}', [PaymentController::class, 'completeQrisPayment'])
            ->name('payment.qris.complete');
        Route::post('/callback', [PaymentController::class, 'callback'])
            ->name('payment.callback');
        Route::post('/ajax-callback', [PaymentController::class, 'callback'])
            ->withoutMiddleware([VerifyCsrfToken::class]) // atau exclude CSRF di VerifyCsrfToken
            ->name('payment.ajax-callback');
        Route::get('/history', [PaymentController::class, 'history'])
            ->name('payment.history');
        Route::get('/{orderId}', [PaymentController::class, 'detail'])
            ->name('payment.detail');
    });
});



require __DIR__ . '/auth.php';
