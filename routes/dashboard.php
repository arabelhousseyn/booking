<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\SellerController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\ReasonsController;
use App\Http\Controllers\Dashboard\NotificationTemplateController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\ReviewsController;
use App\Http\Controllers\Dashboard\CouponsController;
use App\Http\Controllers\Dashboard\VehiclesController;
use App\Http\Controllers\Dashboard\HousesController;
use App\Http\Controllers\Dashboard\BookingsController;

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
        Route::get('/reviews', ReviewsController::class)->name('dashboard.reviews.index');

        // coupons
        Route::resource('/coupons/', CouponsController::class)->names([
            'index' => 'dashboard.coupons.index',
            'create' => 'dashboard.coupons.create',
            'store' => 'dashboard.coupons.store',
        ]);

        Route::get('/coupons/{coupon}/edit', [CouponsController::class, 'edit'])->name('dashboard.coupons.edit');
        Route::put('/coupons/{coupon}/update', [CouponsController::class, 'update'])->name('dashboard.coupons.update');
        Route::delete('/coupons/{coupon}/destroy', [CouponsController::class, 'destroy'])->name('dashboard.coupons.destroy');

        // vehicles
        Route::resource('/vehicles/', VehiclesController::class)->names([
            'index' => 'dashboard.vehicles.index',
            'create' => 'dashboard.vehicles.create',
            'store' => 'dashboard.vehicles.store',
        ]);

        Route::post('/vehicles/{vehicle}/decline', [VehiclesController::class, 'decline'])->name('dashboard.vehicles.decline');
        Route::post('/vehicles/{vehicle}/publish', [VehiclesController::class, 'publish'])->name('dashboard.vehicles.publish');
        Route::get('/vehicles/{vehicle}/show', [VehiclesController::class, 'show'])->name('dashboard.vehicles.show');
        Route::get('/vehicles/{vehicle}/edit', [VehiclesController::class, 'edit'])->name('dashboard.vehicles.edit');
        Route::put('/vehicles/{vehicle}/update', [VehiclesController::class, 'update'])->name('dashboard.vehicles.update');
        Route::delete('/vehicles/{vehicle}/destroy', [VehiclesController::class, 'destroy'])->name('dashboard.vehicles.destroy');

        // houses
        Route::resource('/houses/', HousesController::class)->names([
            'index' => 'dashboard.houses.index',
            'create' => 'dashboard.houses.create',
            'store' => 'dashboard.houses.store',
        ]);

        Route::post('/houses/{house}/decline', [HousesController::class, 'decline'])->name('dashboard.houses.decline');
        Route::post('/houses/{house}/publish', [HousesController::class, 'publish'])->name('dashboard.houses.publish');
        Route::get('/houses/{house}/show', [HousesController::class, 'show'])->name('dashboard.houses.show');
        Route::get('/houses/{house}/edit', [HousesController::class, 'edit'])->name('dashboard.houses.edit');
        Route::put('/houses/{house}/update', [HousesController::class, 'update'])->name('dashboard.houses.update');
        Route::delete('/houses/{house}/destroy', [HousesController::class, 'destroy'])->name('dashboard.houses.destroy');

        // bookings
        Route::resource('/bookings/', BookingsController::class)->names([
            'index' => 'dashboard.bookings.index',
            'create' => 'dashboard.bookings.create',
            'store' => 'dashboard.bookings.store',
        ]);

        Route::post('/bookings/{booking}/decline', [BookingsController::class, 'decline'])->name('dashboard.bookings.decline');
        Route::post('/bookings/{booking}/accept', [BookingsController::class, 'accept'])->name('dashboard.bookings.accept');
        Route::get('/bookings/{booking}/state', [BookingsController::class, 'bookingState'])->name('dashboard.bookings.state');
        Route::get('/bookings/{booking}/show', [BookingsController::class, 'show'])->name('dashboard.bookings.show');
        Route::get('/bookings/{booking}/edit', [BookingsController::class, 'edit'])->name('dashboard.bookings.edit');
        Route::put('/bookings/{booking}/update', [BookingsController::class, 'update'])->name('dashboard.bookings.update');
        Route::delete('/bookings/{booking}/destroy', [BookingsController::class, 'destroy'])->name('dashboard.bookings.destroy');


        /** settings */

        // general
        Route::get('/general', [SettingsController::class, 'general'])->name('dashboard.settings.general');
        Route::post('/core', [SettingsController::class, 'updateCore'])->name('dashboard.settings.core');

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
        Route::get('/notification_template', [NotificationTemplateController::class, 'index'])->name('dashboard.notificationTemplate.index');
        Route::post('/notification_template', [NotificationTemplateController::class, 'push'])->name('dashboard.notificationTemplate.push');

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

    // authentication
    require __DIR__.'/auth.php';
});
