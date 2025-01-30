@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
        </div>

        <h1>{{ $post->title }}</h1>
        <p><strong>Category:</strong> {{ $post->category?->name ?? 'Uncategorized' }}</p>
        <p><strong>Author:</strong> {{ $post->user->username }}</p>
        <p>{{ $post->description }}</p>

        <!-- Post Image -->
        @if ($post->imageUrl)
            <div class="mt-4">
                <img src="{{ $post->imageUrl }}" alt="Post Image" class="img-fluid rounded">
            </div>
        @endif

        <!-- Vote Counts -->
        <div class="mt-4">
            <strong>Votes:</strong>
            <span class="text-success">Upvotes: {{ $post->votes->where('vote_type', true)->count() }}</span> |
            <span class="text-danger">Downvotes: {{ $post->votes->where('vote_type', false)->count() }}</span>
        </div>

        <!-- Voting Buttons -->
        <div class="mt-3">
            <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Upvote</button>
            </form>

            <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Downvote</button>
            </form>
        </div>

        <!-- Comment Form -->
        <div class="mt-4">
            <h3>Add a Comment</h3>
            <form action="{{ route('comments.store', $post) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="content" class="form-label">Your Comment</label>
                    <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <!-- Display Comments -->
        <div class="mt-4">
            <h3>Comments</h3>
            @forelse ($post->comments as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="card-text">{{ $comment->content }}</p>
                        <p class="card-text">
                            <small class="text-muted">
                                By: {{ $comment->user->username }} | {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </p>
                    </div>
                </div>
            @empty
                <div class="alert alert-info" role="alert">
                    No comments yet.
                </div>
            @endforelse
        </div>
    </div>
@endsection