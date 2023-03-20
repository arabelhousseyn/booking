<?php

use App\Http\Controllers\Api\V1\Auth\Sellers\AuthController as SellerAuthController;
use App\Http\Controllers\Api\V1\Auth\Users\AuthController as UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return [];});

require __DIR__.'/dashboard.php';


Route::get('/user-password-reset', function () {
    return view('emails.passwords.user-password-reset');
});

Route::get('/seller-password-reset', function () {
    return view('emails.passwords.seller-password-reset');
});

Route::post('/user-password-reset', [UserAuthController::class, 'resetPassword'])->name('user-password-reset');
Route::post('/seller-password-reset', [SellerAuthController::class, 'resetPassword'])->name('seller-password-reset');
