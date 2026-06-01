<?php

use App\Http\Controllers\ProfileController;

// ADMIN
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DataKucingAdminController;

//CLIENT
use App\Http\Controllers\DataKucingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing');

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        

        Route::get('/data-user', [UserController::class, 'index'])->name('data-user');
        Route::post('/data-user', [UserController::class, 'store'])->name('data-user.store');
        Route::put('/data-user/{id}', [UserController::class, 'update'])->name('data-user.update');
        Route::delete('/data-user/{id}', [UserController::class, 'destroy'])->name('data-user.destroy');


        Route::get('/data-kucing', [DataKucingAdminController::class, 'index'])->name('data-kucing'); // Tetap pakai data-user sesuai action di blade lama atau sesuaikan ke data-kucing
        Route::post('/data-kucing', [DataKucingAdminController::class, 'store'])->name('data-kucing.store');
        Route::put('/data-kucing/{id}', [DataKucingAdminController::class, 'update'])->name('data-kucing.update');
        Route::delete('/data-kucing/{id}', [DataKucingAdminController::class, 'destroy'])->name('data-kucing.destroy');

    });

Route::middleware(['auth', 'role:client'])
    ->prefix('client') // Menghasilkan URL: /client/data-kucing
    ->name('client.')  // Menghasilkan Nama: client.data-kucing.index
    ->group(function () {

        Route::get('/data-kucing', [DataKucingController::class, 'index'])->name('data-kucing.index');
        Route::put('/data-kucing/update/{id}', [DataKucingController::class, 'update'])->name('data-kucing.update');
        Route::get('/data-kucing/{id}/download-qr', [DataKucingController::class, 'downloadQrCode'])
         ->name('data-kucing.download-qr');

        Route::get('/payment', [PaymentController::class, 'index'])
        ->name('payment.index');

        Route::post('/payment/create', [PaymentController::class, 'create'])
        ->name('payment.create');

        Route::get('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    });

Route::get('/scan-kucing/{qr_code}', [DataKucingController::class, 'showPublic'])
     ->name('kucing.public-profile');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
