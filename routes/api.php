<?php

/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
|
*/
Route::middleware(['api_version', 'locale'])->group(function () {
    require('api_v1.php');
});
