<?php


use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\SellerController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ReasonsController;
use App\Http\Controllers\Dashboard\NotificationTemplateController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\ReviewsController;

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
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('dashboard.admins.edit');
        Route::put('/admins/{admin}/update', [AdminController::class, 'update'])->name('dashboard.admins.update');
        Route::delete('/admins/{admin}/destroy', [AdminController::class, 'destroy'])->name('dashboard.admins.destroy');

        // sellers
        Route::resource('/sellers/', SellerController::class)->names([
            'index' => 'dashboard.sellers.index',
            'create' => 'dashboard.sellers.create',
            'store' => 'dashboard.sellers.store',
        ]);

        Route::get('/sellers/{seller}/edit', [SellerController::class, 'edit'])->name('dashboard.sellers.edit');
        Route::put('/sellers/{seller}/update', [SellerController::class, 'update'])->name('dashboard.sellers.update');
        Route::delete('/sellers/{seller}/destroy', [SellerController::class, 'destroy'])->name('dashboard.sellers.destroy');

        //users
        Route::resource('/users/', UserController::class)->names([
            'index' => 'dashboard.users.index',
            'create' => 'dashboard.users.create',
            'store' => 'dashboard.users.store',
        ]);

        Route::get('/users/{user}/show', [UserController::class, 'show'])->name('dashboard.users.show');
        Route::post('/{user}/{document}/users', [UserController::class, 'document'])->name('dashboard.users.documents')->scopeBindings();
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('dashboard.users.edit');
        Route::put('/users/{user}/update', [UserController::class, 'update'])->name('dashboard.users.update');
        Route::delete('/users/{user}/destroy', [UserController::class, 'destroy'])->name('dashboard.users.destroy');


        // review
        Route::get('/reviews',ReviewsController::class)->name('dashboard.reviews.index');

        /** settings */

        // general
        Route::get('/general', [SettingsController::class, 'general'])->name('dashboard.settings.general');
        Route::post('/core',[SettingsController::class,'updateCore'])->name('dashboard.settings.core');

        // reasons
        Route::resource('/reasons/', ReasonsController::class)->names([
            'index' => 'dashboard.reasons.index',
            'create' => 'dashboard.reasons.create',
            'store' => 'dashboard.reasons.store',
        ]);

        Route::get('/reasons/{reason}/edit', [ReasonsController::class, 'edit'])->name('dashboard.reasons.edit');
        Route::put('/reasons/{reason}/update', [ReasonsController::class, 'update'])->name('dashboard.reasons.update');
        Route::delete('/reasons/{reason}/destroy', [ReasonsController::class, 'destroy'])->name('dashboard.reasons.destroy');

        // push notification
        Route::get('/notification_template',[NotificationTemplateController::class,'index'])->name('dashboard.notificationTemplate.index');
        Route::post('/notification_template',[NotificationTemplateController::class,'push'])->name('dashboard.notificationTemplate.push');

        // roles and permissions
        Route::resource('/roles/', RolesController::class)->names([
            'index' => 'dashboard.roles.index',
            'create' => 'dashboard.roles.create',
            'store' => 'dashboard.roles.store',
        ]);

        Route::get('/roles/{role}/show', [RolesController::class, 'show'])->name('dashboard.roles.show');
        Route::get('/roles/{role}/edit', [RolesController::class, 'edit'])->name('dashboard.roles.edit');
        Route::put('/roles/{role}/update', [RolesController::class, 'update'])->name('dashboard.roles.update');
        Route::delete('/roles/{role}/destroy', [RolesController::class, 'destroy'])->name('dashboard.roles.destroy');
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
