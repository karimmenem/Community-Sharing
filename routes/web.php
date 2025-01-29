<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::get('login', fn() => view('auth.login'))->name('login');
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');
Route::get('register', fn() => view('auth.signup'))->name('register');
Route::post('register', [UserController::class, 'register']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Post Routes
    Route::resource('posts', PostController::class);
    
    Route::get('/create-post', [PostController::class, 'create'])->name('posts.create');
    // Voting Routes
    Route::post('/posts/{post}/upvote', [VoteController::class, 'upvote'])->name('posts.vote.upvote');
    Route::post('/posts/{post}/downvote', [VoteController::class, 'downvote'])->name('posts.vote.downvote');
    Route::delete('/posts/{post}/vote', [VoteController::class, 'removeVote'])->name('posts.vote.remove');

    // Comment Routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // User Profile Routes
    Route::get('user/profile', fn() => view('user.profile'))->name('user.profile');
    Route::get('user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
    Route::get('admin/manage-posts', [AdminController::class, 'managePosts'])->name('admin.managePosts');
});

// Search Route
Route::get('/search', [PostController::class, 'search'])->name('posts.search');