@extends('layout.master')

@section('content')
    <div class="container mt-4">
        <h1>Posts</h1>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-4">
                <form id="filter-form" method="GET" action="{{ route('posts.index') }}">
                    <div class="input-group">
                        <!-- Category Filter -->
                        <select name="category" id="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->categoryId }}" {{ request('category') == $category->categoryId ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Sort Filter -->
                        <select name="sort" id="sort" class="form-select">
                            <option value="">Sort By</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>

                        <!-- Reputation Filter -->
                        <select name="reputation" id="reputation" class="form-select">
                            <option value="">Filter by Reputation</option>
                            <option value="100" {{ request('reputation') == 100 ? 'selected' : '' }}>100+ Reputation</option>
                            <option value="500" {{ request('reputation') == 500 ? 'selected' : '' }}>500+ Reputation</option>
                            <option value="1000" {{ request('reputation') == 1000 ? 'selected' : '' }}>1000+ Reputation</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Posts Container -->
        <div id="posts-container">
            @forelse($posts as $post)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>

                        <!-- Post Thumbnail -->
                        @if ($post->imageUrl)
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

                        <!-- Comments Count -->
                        <p class="card-text">
                            <strong>Comments:</strong> {{ $post->comments->count() }}
                        </p>

                        <!-- Voting Buttons -->
                        <form action="{{ route('posts.vote.upvote', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Upvote</button>
                        </form>

                        <form action="{{ route('posts.vote.downvote', $post) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Downvote</button>
                        </form>

                        <!-- Comments Section -->
                        <div class="mt-3">
                            <h6>Comments:</h6>
                            <ul class="list-group">
                                @forelse($post->comments as $comment)
                                    <li class="list-group-item">
                                        <strong>{{ $comment->user->username }}:</strong> {{ $comment->content }}
                                    </li>
                                @empty
                                    <li class="list-group-item">No comments yet.</li>
                                @endforelse
                            </ul>
                        </div>

                        <!-- Add Comment Form -->
                        <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="content" class="form-control" placeholder="Add a comment..." required>
                                <button type="submit" class="btn btn-primary">Comment</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <div class="alert alert-info" role="alert">
                    No posts available.
                </div>
            @endforelse
        </div>

        <!-- Show More Button -->
        @if ($posts->hasMorePages())
            <div class="text-center mt-4">
                <button id="show-more" class="btn btn-primary">Show More</button>
            </div>
        @endif
    </div>

    <!-- AJAX Script for "Show More" -->
    <script>
        document.getElementById('show-more').addEventListener('click', function () {
            const button = this;
            const postsContainer = document.getElementById('posts-container');
            const nextPageUrl = '{{ $posts->nextPageUrl() }}';

            if (!nextPageUrl) {
                button.disabled = true;
                return;
            }

            // Fetch the next page of posts
            fetch(nextPageUrl)
                .then(response => response.text()) // Parse the response as HTML
                .then(html => {
                    // Append new posts to the container
                    postsContainer.insertAdjacentHTML('beforeend', html);

                    // Update the "Show More" button
                    const nextPageUrl = new DOMParser()
                        .parseFromString(html, 'text/html')
                        .querySelector('#show-more')
                        ?.dataset.nextPageUrl;

                    if (nextPageUrl) {
                        button.dataset.nextPageUrl = nextPageUrl;
                    } else {
                        button.disabled = true;
                        button.textContent = 'No more posts';
                    }
                })
                .catch(error => console.error('Error loading more posts:', error));
        });

        // Automatically submit the filter form when a filter is changed
        document.getElementById('category').addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });

        document.getElementById('sort').addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });

        document.getElementById('reputation').addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });
    </script>
@endsection