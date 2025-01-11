@include('layout.header', ['title' => 'Welcome'])
<div class="container text-center my-5">
    <h1>Welcome to the Community Knowledge Sharing Platform</h1>
    <p class="lead mt-4">Share your ideas, tips, and solutions with the community.</p>
    
    <!-- Buttons -->
    <div class="mt-4">
        <a href="{{ route('auth.login') }}" class="btn btn-primary btn-lg mx-2">Sign In</a>
        <a href="{{ route('auth.register') }}" class="btn btn-success btn-lg mx-2">Sign Up</a>
    </div>
</div>

@include('layout.footer')
        