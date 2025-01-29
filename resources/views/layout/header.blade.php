<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Community Sharing</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    
<header>
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #6f42c1;">
  <div class="container">
    <!-- Logo on the left -->
    <a href="/" class="navbar-brand text-white" style="font-family: 'Comic Sans MS', sans-serif; font-size: 28px;">
      Share Space
    </a>

    <!-- Middle Links (Home, Dashboard, Create Post) -->
    <div class="d-flex mx-auto">
      <a href="/posts" class="nav-link text-white mx-4" style="font-size: 22px;">Home</a>
      <a href="{{ route('user.dashboard') }}" class="nav-link text-white mx-4" style="font-size: 22px;">Dashboard</a>
      <a href="{{ route('posts.create') }}" class="nav-link text-white mx-4" style="font-size: 22px;">Create Post</a>

    </div>

    <!-- Search Bar and Logout on the Right -->
    <div class="d-flex">
    <form action="{{ route('posts.search') }}" method="GET" class="d-flex">
    <input type="search" name="query" class="form-control me-2" placeholder="Search..." aria-label="Search">
    <button type="submit" class="btn btn-outline-light">Search</button>
</form>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-light">Logout</button>
      </form>
    </div>
  </div>
</nav>


</header>
