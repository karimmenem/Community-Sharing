@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>{{ auth()->user()->username }}'s Profile</h1>
        <p><strong>Reputation Points:</strong> {{ auth()->user()->reputationPoints }}</p>
        <h2>Your Posts</h2>
        @forelse (auth()->user()->posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                    <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm">View Post</a>
                </div>
            </div>
        @empty
            <p>You have no posts yet.</p>
        @endforelse
    </div>
@endsection