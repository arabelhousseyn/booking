<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\Users\AuthController as UserAuthController;
use App\Http\Controllers\Api\V1\Auth\Sellers\AuthController as SellerAuthController;
use App\Http\Controllers\Api\V1\SellerController;
use App\Http\Controllers\Api\V1\UserController;

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


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserAuthController::class, 'logout'])->name('users.logout');


        Route::controller(UserController::class)->group(function () {
            Route::post('/store-favorite', 'StoreFavorite')->name('users.store-favorites');
            Route::get('/favorites', 'getFavorites')->name('users.get-favorites');
            Route::delete('/destroy-favorite/{user}/{favorite}', 'destroyFavorite')->name('users.destroy-favorite')->scopeBindings();
            Route::post('/profile', 'updateProfile')->name('users-update-profile');
            Route::put('/password', 'updatePassword')->name('users-update-password');
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
            //profile
            Route::post('/profile', 'updateProfile')->name('sellers-update-profile');
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
