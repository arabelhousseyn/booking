<?php

use App\Http\Controllers\Api\V1\Auth\Users\AuthController;
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


Route::get('/user-password-reset',function (){
    return view('emails.passwords.user-password-reset');
});

Route::post('/user-password-reset', [AuthController::class, 'resetPassword'])->name('user-password-reset');
