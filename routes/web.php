<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataKucingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'role:client'])
    ->prefix('client') // Menghasilkan URL: /client/data-kucing
    ->name('client.')  // Menghasilkan Nama: client.data-kucing.index
    ->group(function () {

        Route::get('/data-kucing', [DataKucingController::class, 'index'])->name('data-kucing.index');
        Route::put('/data-kucing/update/{id}', [DataKucingController::class, 'update'])->name('data-kucing.update');
        Route::get('/data-kucing/{id}/download-qr', [DataKucingController::class, 'downloadQrCode'])
         ->name('data-kucing.download-qr');

    });

Route::get('/scan-kucing/{qr_code}', [DataKucingController::class, 'showPublic'])
     ->name('kucing.public-profile');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
