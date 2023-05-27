<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\Users\AuthController as UserAuthController;
use App\Http\Controllers\Api\V1\Auth\Sellers\AuthController as SellerAuthController;
use App\Http\Controllers\Api\V1\SellerController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\CoreController;

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
*/
Route::prefix('/v1/users')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', [UserAuthController::class, 'login'])->name('users.login');
        Route::post('/signup', [UserAuthController::class, 'signup'])->name('users.signup');
        Route::post('/otp/{user}', [UserAuthController::class, 'otpPhoneNumber'])->name('users.otp');
        Route::post('/verify-phone-number/{user}', [UserAuthController::class, 'verifyPhoneNumber'])->name('users.verify-phone-number');
        Route::post('/documents/{user}', [UserAuthController::class, 'uploadDocuments'])->name('users.documents');
        Route::post('/forgot-password', [UserAuthController::class, 'forgotPassword'])->name('users.forgot-password');
    });

    // special case: so this two endpoints work in guest mode
    Route::get('/guest-list-vehicles', [UserController::class, 'listVehicles'])->name('users.list-vehicles');
    Route::get('/guest-list-houses', [UserController::class, 'listHouses'])->name('users.list-houses');


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('users.logout');


        Route::controller(UserController::class)->group(function () {
            // favorites
            Route::post('/store-favorite', 'storeFavorite')->name('users.store-favorites');
            Route::get('/favorites', 'getFavorites')->name('users.get-favorites');
            Route::delete('/destroy-favorite/{user}/{favorite}', 'destroyFavorite')->name('users.destroy-favorite')->scopeBindings();

            // profile
            Route::post('/profile', 'updateProfile')->name('users-update-profile');
            Route::get('/profile', 'profile')->name('users-profile');
            Route::put('/password', 'updatePassword')->name('users-update-password');

            // booking
            Route::post('/booking', 'storeBooking')->name('users.store-booking');
            Route::get('/booking/{booking}', 'viewBooking')->name('users.view-booking');
            Route::get('/bookings', 'bookings')->name('users.bookings');
            Route::post('/decline-booking/{booking}', 'declineBooking')->name('users.decline-booking');
            Route::post('/booking-state/{booking}', 'bookingState')->name('users.booking-state');
            Route::post('/booking-payment-status/{booking}', 'bookingPaymentStatus')->name('users.booking-payment-status');
            Route::post('/store-review', 'storeReview')->name('users.store-review');
            Route::get('/reasons', 'reasons')->name('users.reasons');
            Route::get('/coupons', 'coupons')->name('users.coupons');
            Route::get('/list-vehicles', 'listVehicles')->name('users.list-vehicles');
            Route::get('/list-houses', 'listHouses')->name('users.list-houses');
            Route::get('/ads', 'ads')->name('users.ads');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Seller
|--------------------------------------------------------------------------
|
*/

Route::prefix('/v1/sellers')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', [SellerAuthController::class, 'login'])->name('sellers.login');
        Route::post('/signup', [SellerAuthController::class, 'signup'])->name('sellers.signup');
        Route::post('/otp/{seller}', [SellerAuthController::class, 'otpPhoneNumber'])->name('sellers.otp');
        Route::post('/verify-phone-number/{seller}', [SellerAuthController::class, 'verifyPhoneNumber'])->name('sellers.verify-phone-number');
        Route::post('/forgot-password', [SellerAuthController::class, 'forgotPassword'])->name('sellers.forgot-password');
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('sellers.logout');

        Route::controller(SellerController::class)->group(function () {
            Route::get('/booking/{booking}', 'viewBooking')->name('users.view-booking');
            Route::get('/bookings', 'bookings')->name('sellers.bookings');
            Route::post('/terminate-booking/{booking}', 'terminateBooking')->name('sellers.terminate-booking');

            //profile
            Route::post('/profile', 'updateProfile')->name('sellers-update-profile');
            Route::get('/profile', 'profile')->name('sellers-profile');
            Route::put('/password', 'updatePassword')->name('sellers-update-password');


            // vehicle
            Route::post('/vehicle', 'storeVehicle')->name('sellers.vehicle');
            Route::post('/vehicle/{seller}/{vehicle}', 'storeVehicleDocuments')->name('sellers-vehicle-documents')->scopeBindings();
            Route::get('/vehicle', 'vehicles')->name('sellers.get-vehicles');

            // house
            Route::post('/house', 'storeHouse')->name('sellers.house');
            Route::get('/house', 'houses')->name('sellers.get-houses');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Core
|--------------------------------------------------------------------------
|
*/

Route::get('/v1/core', CoreController::class)->name('core');

