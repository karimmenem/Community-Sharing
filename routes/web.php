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
Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('welcome');
})->name('logout');

Route::get('register', fn() => view('auth.signup'))->name('register');
Route::post('register', [UserController::class, 'register']);

// Add the welcome route here
Route::get('/welcome', fn() => view('welcome'))->name('welcome');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Post Routes
    Route::resource('posts', PostController::class);

    // Voting Routes
    Route::post('/posts/{post}/upvote', [VoteController::class, 'upvote'])->name('posts.vote.upvote');
    Route::post('/posts/{post}/downvote', [VoteController::class, 'downvote'])->name('posts.vote.downvote');
    Route::delete('/posts/{post}/vote', [VoteController::class, 'removeVote'])->name('posts.vote.remove');

    // Comment Routes
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // User Profile Routes
    Route::get('user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('user/edit-profile', [UserController::class, 'editProfile'])->name('user.editProfile');
    Route::post('user/update-profile', [UserController::class, 'updateProfile'])->name('user.updateProfile');
    Route::get('user/change-password', [UserController::class, 'showChangePasswordForm'])->name('user.changePasswordForm');
    Route::post('user/change-password', [UserController::class, 'changePassword'])->name('user.changePassword');
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/manage-users', [AdminController::class, 'manageUsers'])->name('admin.manageUsers');
    Route::get('admin/manage-posts', [AdminController::class, 'managePosts'])->name('admin.managePosts');
    Route::delete('admin/delete-user/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::delete('admin/delete-post/{id}', [AdminController::class, 'deletePost'])->name('admin.deletePost');
});

// Search Route
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
