<?php

use App\Http\Controllers\Api\V1\Auth\Users\AuthController as UserAuthController;
use App\Http\Controllers\Api\V1\Auth\Sellers\AuthController as SellerAuthController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return [];
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:admin', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/user-password-reset', function () {
    return view('emails.passwords.user-password-reset');
});

Route::get('/seller-password-reset', function () {
    return view('emails.passwords.seller-password-reset');
});

Route::post('/user-password-reset', [UserAuthController::class, 'resetPassword'])->name('user-password-reset');
Route::post('/seller-password-reset', [SellerAuthController::class, 'resetPassword'])->name('seller-password-reset');
