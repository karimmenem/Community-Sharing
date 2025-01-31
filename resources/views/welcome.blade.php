<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body style="background-image: url('/images/community background.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">

<div class="px-4 py-5 my-5 text-center">
    <h1 class="display-5 fw-bold ShareTitle">Share Sphere</h1>
    <div class="col-lg-6 mx-auto">
        <p class="lead mb-4 welcomePar">Join a community where knowledge flows freely. Share your experiences, solve problems together, and grow with like-minded individuals. Whether you're seeking advice or offering insights, ShareSphere is the space to exchange ideas and make a difference.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <!-- Login Button with Purple Color -->
            <button type="button" class="btn btn-purple btn-lg px-4 gap-3 custom-primary-btn" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
            <button type="button" class="btn btn-outline-secondary btn-lg px-4 custom-secondary-btn" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</button>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-light-purple text-white">Login</button>
                    
                    <!-- Change Password Button -->
                    <div class="mt-3">
                    <a href="{{ route('user.changePasswordForm') }}" class="btn btn-dark-purple">Change Password</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @include('auth.signup') <!-- Include signup form here -->
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
