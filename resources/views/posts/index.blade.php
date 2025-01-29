@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>Posts</h1>

        @forelse($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>

                    <!-- Post Thumbnail -->
                    @if ($post->image)
                        <img src="{{ $post->imageUrl }}" alt="Post Thumbnail" class="img-thumbnail mb-2" style="max-width: 200px;">
                    @endif

                    <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                    <p class="card-text">
                        <small class="text-muted">
                            Category: {{ $post->category?->name ?? 'Uncategorized' }}
                        </small><br>
                        <small class="text-muted">Author: {{ $post->user->username }}</small>
                    </p>

                    <!-- Vote Summary -->
                    <p class="card-text">
                        <strong>Votes:</strong>
                        <span class="text-success">Upvotes: {{ $post->votes->where('vote_type', true)->count() }}</span> |
                        <span class="text-danger">Downvotes: {{ $post->votes->where('vote_type', false)->count() }}</span>
                    </p>

                    <!-- Voting Buttons -->
                    @php
                        $userVote = $post->votes->firstWhere('user_id', auth()->id());
                    @endphp

                    @if (!$userVote)
                        <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Upvote</button>
                        </form>

                        <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Downvote</button>
                        </form>
                    @else
                        @if ($userVote->vote_type)
                            <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Change to Downvote</button>
                            </form>
                        @else
                            <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Change to Upvote</button>
                            </form>
                        @endif

                        <form action="{{ route('posts.vote.remove', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-sm">Remove Vote</button>
                        </form>
                    @endif

                    <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm">View Post</a>
                </div>
            </div>
        @empty
            <p>No posts available.</p>
        @endforelse
    </div>
@endsection