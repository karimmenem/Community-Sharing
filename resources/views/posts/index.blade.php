@extends('layout.master') <!-- Assuming you have a master layout -->

@section('content')
    <div class="container mt-4">
        <h1>All Posts</h1>
        <div class="post-list">
            @foreach ($posts as $post)
                <div class="post-card">
                    <h2>{{ $post->title }}</h2>
                    <p>{{ $post->description }}</p>
                    <a href="{{ route('posts.show', $post->postId) }}">Read More</a>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endsection
