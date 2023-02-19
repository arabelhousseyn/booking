<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\Users\AuthController;

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
