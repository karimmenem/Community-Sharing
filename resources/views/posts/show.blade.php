@extends('layout.master') <!-- Assuming you have a master layout -->

@section('content')
    <div class="container mt-4">
        <h1>{{ $post->title }}</h1>
        <p><strong>Category:</strong> {{ $post->category->name }}</p>
        <p><strong>Author:</strong> {{ $post->user->username }}</p>
        <p>{{ $post->description }}</p>

        <div class="mt-4">
            <strong>Votes:</strong> 
            <span class="text-success">Upvotes: {{ $post->votes->where('vote_type', true)->count() }}</span> | 
            <span class="text-danger">Downvotes: {{ $post->votes->where('vote_type', false)->count() }}</span>
        </div>

        <!-- Voting Buttons -->
        @auth
            <form action="{{ route('posts.vote.upvote', $post->postId) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">Upvote</button>
            </form>
            <form action="{{ route('posts.vote.downvote', $post->postId) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Downvote</button>
            </form>
        @else
            <p class="mt-2 text-muted">Log in to vote on this post.</p>
        @endauth
    </div>
@endsection
