<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\Users\AuthController;
use App\Http\Controllers\Api\V1\Auth\Sellers\AuthController as SellerAuthController;
use App\Http\Controllers\Api\V1\SellerController;

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
*/
Route::prefix('/v1/users')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::post('/login', [AuthController::class, 'login'])->name('users.login');
        Route::post('/signup', [AuthController::class, 'signup'])->name('users.signup');
        Route::post('/otp/{user}', [AuthController::class, 'otpPhoneNumber'])->name('users.otp');
        Route::post('/verify-phone-number/{user}', [AuthController::class, 'verifyPhoneNumber'])->name('users.verify-phone-number');
        Route::post('/documents/{user}', [AuthController::class, 'uploadDocuments'])->name('users.documents');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('users.forgot-password');
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('users.logout');
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
        Route::post('/logout', [AuthController::class, 'logout'])->name('sellers.logout');

        Route::controller(SellerController::class)->group(function () {
            // vehicle
            Route::post('/vehicle/{seller}', 'storeVehicle')->name('sellers.vehicle');
            Route::post('/vehicle/{seller}/{vehicle}', 'storeVehicleDocuments')->name('sellers-vehicle-documents')->scopeBindings();
            Route::get('/vehicle/{seller}', 'vehicles')->name('sellers.get-vehicles');

            // house
            Route::post('/house/{seller}','storeHouse')->name('sellers.house');
            Route::get('/house/{seller}','houses')->name('sellers.get-houses');
        });
    });
});
