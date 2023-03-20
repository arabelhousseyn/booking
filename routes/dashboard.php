<?php


use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;

Route::prefix('dashboard')->group(function () {

    Route::middleware(['auth:admin', 'verified'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');
    });


    // edit profile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


    // authentication
    require __DIR__.'/auth.php';
});
