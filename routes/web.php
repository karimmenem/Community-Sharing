<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/', [HomeController::class, 'index'])->name('home'); // Home route

// Login Routes
Route::get('login', function () {
    return view('auth.login'); // Show the login form
})->name('login');

Route::post('login', [UserController::class, 'login']); // Handle login form submission

// Logout Route
Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home'); // Redirect to home page after logout
})->name('logout');

// Register Routes
Route::get('register', function () {
    return view('auth.signup'); // Show the signup form
})->name('register');

Route::post('register', [UserController::class, 'register']); // Handle signup form submission

// Authenticated Routes for User Profile Management
Route::middleware('auth')->group(function() {
    // Posts
    Route::get('posts', [PostController::class, 'index'])->name('posts.index'); // Posts Index Page
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create'); // Create Post Page
    Route::post('posts', [PostController::class, 'store'])->name('posts.store'); // Store Post
    Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show'); // Show Single Post
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit'); // Edit Post Page
    Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update'); // Update Post
    Route::delete('posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy'); // Delete Post

    // User Profile
    Route::get('user/profile', function () {
        return view('user.profile'); // Show the profile page
    })->name('user.profile');

    Route::get('user/dashboard', function () {
        return view('user.dashboard'); // Show user dashboard page
    })->name('user.dashboard');
});
