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
            @include('posts._post', ['posts' => $posts]) <!-- Include the partial view -->
        </div>

        <!-- Show More Button -->
        @if ($posts->hasMorePages())
            <div class="text-center mt-4">
                <button id="show-more" class="btn btn-primary" data-next-page-url="{{ $posts->nextPageUrl() }}">Show More</button>
            </div>
        @endif
    </div>

    <!-- AJAX Script for "Show More" -->
    <script>
        document.getElementById('show-more').addEventListener('click', function () {
            const button = this;
            const postsContainer = document.getElementById('posts-container');
            const nextPageUrl = button.dataset.nextPageUrl;

            if (!nextPageUrl) {
                button.disabled = true;
                return;
            }

            // Fetch the next page of posts
            fetch(nextPageUrl)
                .then(response => response.text())
                .then(html => {
                    // Get the new posts and append them
                    const newPosts = new DOMParser().parseFromString(html, 'text/html').querySelector('#posts-container').innerHTML;
                    postsContainer.insertAdjacentHTML('beforeend', newPosts);

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
    </script>
@endsection
