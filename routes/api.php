<?php

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
*/
// todo : comment out the api version middleware ( for deployment )
use Illuminate\Support\Facades\Route;

Route::middleware('api_version')->group(function () {
require('api_v1.php');
});
