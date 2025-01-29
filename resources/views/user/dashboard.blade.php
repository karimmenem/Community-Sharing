@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>{{ $user->username }}'s Dashboard</h1>
        <p><strong>Reputation Points:</strong> {{ $user->reputationPoints }}</p>

        <h2>Your Posts</h2>
        @forelse ($posts as $post)
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

        <h2>Your Comments</h2>
        @forelse ($comments as $comment)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="card-text">{{ $comment->content }}</p>
                    <p class="card-text">
                        <small class="text-muted">
                            On: <a href="{{ route('posts.show', $comment->post) }}">{{ $comment->post->title }}</a> |
                            {{ $comment->created_at->diffForHumans() }}
                        </small>
                    </p>
                </div>
            </div>
        @empty
            <p>You have no comments yet.</p>
        @endforelse
    </div>
@endsection