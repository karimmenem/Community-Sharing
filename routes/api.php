<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController; // assuming your RegisterController is inside this


Route::controller(UserController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

