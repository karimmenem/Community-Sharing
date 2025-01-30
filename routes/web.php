<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Auth;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

Route::get('/register', fn() => view('auth.signup'))->name('register');
Route::post('/register', [UserController::class, 'register']);

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('posts.index'); // Ensure this redirects to posts.index
    })->name('dashboard');

    Route::resource('posts', PostController::class);

    // Voting
    Route::post('/posts/{post}/upvote', [VoteController::class, 'upvote'])->name('posts.vote.upvote');
    Route::post('/posts/{post}/downvote', [VoteController::class, 'downvote'])->name('posts.vote.downvote');
    Route::delete('/posts/{post}/vote', [VoteController::class, 'removeVote'])->name('posts.vote.remove');

    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // User Profile
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
    Route::delete('admin/delete-post/{post}', [AdminController::class, 'deletePost'])->name('admin.deletePost');
});

// Search Route
Route::get('/search', [PostController::class, 'search'])->name('posts.search');