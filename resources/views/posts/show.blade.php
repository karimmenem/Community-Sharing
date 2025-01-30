@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>{{ $post->title }}</h1>
        <p><strong>Category:</strong> {{ $post->category?->name ?? 'Uncategorized' }}</p>
        <p><strong>Author:</strong> {{ $post->user->username }}</p>
        <p>{{ $post->description }}</p>

        <!-- Post Image -->
        @if ($post->image)
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
        @php
            $userVote = $post->votes->where('user_id', auth()->id())->first();
        @endphp

        @if (!$userVote)
            <!-- User has not voted yet -->
            <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Upvote</button>
            </form>

            <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Downvote</button>
            </form>
        @else
            <!-- User has already voted -->
            @if ($userVote->vote_type)
                <!-- User has upvoted, show option to change to downvote -->
                <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Change to Downvote</button>
                </form>
            @else
                <!-- User has downvoted, show option to change to upvote -->
                <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Change to Upvote</button>
                </form>
            @endif

            <!-- Option to remove vote -->
            <form action="{{ route('posts.vote.remove', $post) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-secondary btn-sm">Remove Vote</button>
            </form>
        @endif

        <!-- Comment Form -->
        @auth
            <div class="mt-4">
                <form action="{{ route('comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="content" class="form-label">Add a Comment</label>
                        <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        @else
            <p>Please <a href="{{ route('login') }}">log in</a> to comment.</p>
        @endauth

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
                        @if ($comment->user_id === auth()->id())
                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <p>No comments yet.</p>
            @endforelse
        </div>
    </div>
@endsection