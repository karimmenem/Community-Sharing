<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Public Routes
Route::post('/register', [UserController::class, 'register']);  // For user registration
Route::post('/login', [UserController::class, 'login']);        // For user login

// Protected Routes (requires authentication via Sanctum)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();  // Returns authenticated user's information
    });

    // Add any other routes here that require the user to be authenticated
    // For example:
    // Route::get('/profile', [UserController::class, 'showProfile']);
});
