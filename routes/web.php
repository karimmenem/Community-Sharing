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

// Authenticated Routes for User Profile Management
Route::middleware('auth')->group(function() {
    Route::get('user/profile', function () {
        return view('user.profile'); // Show the profile page
    })->name('user.profile');
    
    Route::get('user/dashboard', function () {
        return view('user.dashboard'); // Show user dashboard page
    })->name('user.dashboard');

    // Optional: Profile edit and change password routes could go here as needed
});
