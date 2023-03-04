<?php

use App\Http\Controllers\Api\V1\Auth\Users\AuthController;
use App\Http\Controllers\Api\V1\Auth\Sellers\AuthController as SellerAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return [];
});

Route::get('/user-password-reset', function () {
    return view('emails.passwords.user-password-reset');
});

Route::get('/seller-password-reset', function () {
    return view('emails.passwords.seller-password-reset');
});

Route::post('/user-password-reset', [AuthController::class, 'resetPassword'])->name('user-password-reset');
Route::post('/seller-password-reset', [SellerAuthController::class, 'resetPassword'])->name('seller-password-reset');
