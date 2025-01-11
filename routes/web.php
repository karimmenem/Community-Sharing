<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Login Routes
Route::get('login', function () {
    return view('auth.login'); // Show the login form
})->name('login');

Route::post('login', [UserController::class, 'login']); // Handle login form submission

// Register Routes
Route::get('register', function () {
    return view('auth.signup'); // Show the signup form
})->name('register');

Route::post('register', [UserController::class, 'register']); // Handle signup form submission
