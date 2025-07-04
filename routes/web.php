<?php

use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('pages.home.index');
})->name('home');


Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan');
Route::get('/lapangan/{slug}', [LapanganController::class, 'show'])->name('lapangan.show');

Route::get('/payment-success', [BookingController::class, 'afterPayment'])->name('after.payment');
Route::get('/booking/success/{booking_number}', [BookingController::class, 'success'])->name('booking.success');
Route::get('/booking/{booking}/retry-payment', [BookingController::class, 'retryPayment'])
    ->name('booking.retry')
    ->middleware('auth');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    // Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::get('settings/pesanan', [ProfileController::class, 'showlist'])->name('profile.showlist')->middleware('auth');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/booking/pay', [BookingController::class, 'pay'])->name('booking.pay')->middleware('auth');
Route::post('/checkout', [BookingController::class, 'checkout'])->name('checkout.process');

Route::post('/midtrans/webhook', [BookingController::class, 'webhook'])->name('midtrans.webhook');

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);


Route::get('/clear-cart-session', function () {
    session()->forget('cart');
    return 'Session cart sudah dihapus. Kembali ke halaman utama dan coba lagi.';
});
require __DIR__.'/auth.php';
