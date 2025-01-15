@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>{{ $post->title }}</h1>
        <p><strong>Category:</strong> {{ $post->category->name }}</p>
        <p><strong>Author:</strong> {{ $post->user->username }}</p>
        <p>{{ $post->description }}</p>

        <!-- Display Vote Counts -->
        <div class="mt-4">
            <strong>Votes:</strong>
            <span class="text-success">Upvotes: {{ $post->votes->where('vote_type', true)->count() }}</span> |
            <span class="text-danger">Downvotes: {{ $post->votes->where('vote_type', false)->count() }}</span>
        </div>

        <!-- Voting Buttons (Visible to all users) -->
        @php
            // Check if the user has already voted on the post
            $userVote = $post->votes->firstWhere('user_id', auth()->id());
        @endphp

        @if (!$userVote)
            <!-- If the user has not voted yet, show Upvote and Downvote buttons -->
            <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">Upvote</button>
            </form>

            <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">Downvote</button>
            </form>
        @else
            <!-- If the user has already voted -->
            @if ($userVote->vote_type)
                <!-- If the user has upvoted, show option to change to downvote -->
                <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Change to Downvote</button>
                </form>
            @else
                <!-- If the user has downvoted, show option to change to upvote -->
                <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">Change to Upvote</button>
                </form>
            @endif

            <!-- Option to remove the user's vote -->
            <form action="{{ route('posts.vote.remove', $post) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-secondary btn-sm">Remove Vote</button>
            </form>
        @endif
    </div>
@endsection
