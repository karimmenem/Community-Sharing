<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Community Knowledge Sharing Platform')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('layout.header') <!-- Include header -->

    <main>
        @yield('content') <!-- Page-specific content -->
    </main>

    @include('layout.footer') <!-- Include footer -->
</body>
</html>
