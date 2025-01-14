    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\UserController;
    
    Route::controller(UserController::class)->group(function() {
        // Public Routes for Registration and Login
        Route::post('register', 'register');
        Route::post('login', 'login');
    });
    
    // Authenticated Routes for User Profile Management
    Route::middleware('auth:sanctum')->controller(UserController::class)->group(function() {
        Route::get('user/profile/{id}', 'getUserProfile');
        Route::put('user/profile/{id}', 'updateUserProfile');
        Route::post('user/change-password/{id}', 'changePassword');
        Route::get('user/posts/{id}', 'getUserPosts');
    });
    