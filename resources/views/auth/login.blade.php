<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Correct link to your styles.css in the public/css folder -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" id="login-card" style="max-width: 400px; width: 100%; border-radius: 10px; background-color: #f8f9fa;">
        <h3 class="text-center mb-4" id="login-title">Welcome Back!</h3>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label fw-bold"><i class="fas fa-lock"></i> Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="Enter your password">
            </div>

            <!-- Login Button with Light Purple Background -->
            <button type="submit" id="login-btn" class="btn btn-light-purple text-white w-100 fw-bold">
                Login <i class="fas fa-sign-in-alt"></i>
            </button>

            <!-- Forgot Password & Register Links -->
            <div class="mt-3 text-center">
                <a href="{{ route('user.changePasswordForm') }}" id="forgot-password-btn" class="btn btn-dark-purple">Forgot Password?</a>
            </div>

            <div class="mt-2 text-center">
                <a href="{{ route('register') }}" id="signup-link" class="btn btn-link">Don't have an account? Sign Up</a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
