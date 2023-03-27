<?php


use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\SellerController;

Route::prefix('dashboard')->group(function () {

    Route::middleware(['auth:admin', 'verified'])->group(function () {
        // dashboard
        Route::get('/', DashboardController::class)->name('dashboard');

        // admins
        Route::resource('/admins/', AdminController::class)->names([
            'index' => 'dashboard.admins.index',
            'create' => 'dashboard.admins.create',
            'store' => 'dashboard.admins.store',
        ]);
        Route::get('/admins/{admin}/edit',[AdminController::class,'edit'])->name('dashboard.admins.edit');
        Route::put('/admins/{admin}/update',[AdminController::class,'update'])->name('dashboard.admins.update');
        Route::delete('/admins/{admin}/destroy',[AdminController::class,'destroy'])->name('dashboard.admins.destroy');

        // sellers
        Route::resource('/sellers/',SellerController::class)->names([
            'index' => 'dashboard.sellers.index',
            'create' => 'dashboard.sellers.create',
            'store' => 'dashboard.sellers.store',
        ]);

        Route::get('/sellers/{seller}/edit',[SellerController::class,'edit'])->name('dashboard.sellers.edit');
        Route::put('/sellers/{seller}/update',[SellerController::class,'update'])->name('dashboard.sellers.update');
        Route::delete('/sellers/{seller}/destroy',[SellerController::class,'destroy'])->name('dashboard.sellers.destroy');
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
