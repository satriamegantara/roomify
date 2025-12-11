<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KosController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PemilikDashboardController;
use App\Http\Controllers\AdminKosController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// Home Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Kos routes (public)
Route::prefix('kos')->name('kos.')->group(function () {
    Route::get('/', [KosController::class, 'index'])->name('index');
    Route::get('/search', [KosController::class, 'search'])->name('search');
    Route::get('/{kos}', [KosController::class, 'show'])->name('show');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Pemilik Dashboard Routes
Route::prefix('pemilik')->name('pemilik.')->middleware(['auth', 'pemilik'])->group(function () {
    Route::get('/dashboard', [PemilikDashboardController::class, 'index'])->name('dashboard');
    Route::get('/kos', [PemilikDashboardController::class, 'kos'])->name('kos.index');
    Route::get('/kos/create', [PemilikDashboardController::class, 'create'])->name('kos.create');
    Route::post('/kos', [PemilikDashboardController::class, 'store'])->name('kos.store');
    Route::get('/kos/{kos}/edit', [PemilikDashboardController::class, 'edit'])->name('kos.edit');
    Route::put('/kos/{kos}', [PemilikDashboardController::class, 'update'])->name('kos.update');
    Route::get('/bookings', [PemilikDashboardController::class, 'bookings'])->name('bookings.index');
    Route::get('/pembayaran', [PemilikDashboardController::class, 'pembayaran'])->name('pembayaran.index');
});

// Admin Kos Management Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/kos', [AdminKosController::class, 'index'])->name('kos.index');
    Route::post('/kos/{kos}/verify', [AdminKosController::class, 'verify'])->name('kos.verify');
    Route::post('/kos/{kos}/status', [AdminKosController::class, 'updateStatus'])->name('kos.status');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Booking
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create/{kos}', [BookingController::class, 'create'])->name('create');
        Route::post('/{kos}', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::put('/{booking}/cancel', [BookingController::class, 'cancel'])->name('cancel');
    });

    // Rating
    Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');

    // Pembayaran
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::get('/{pembayaran}', [PembayaranController::class, 'show'])->name('show');
        Route::post('/{pembayaran}/bukti', [PembayaranController::class, 'uploadBukti'])->name('uploadBukti');
    });

    // Chat
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{chat}', [ChatController::class, 'show'])->name('show');
        Route::post('/send', [ChatController::class, 'send'])->name('send');
    });
});

require __DIR__ . '/auth.php';
