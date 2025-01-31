@foreach($posts as $post)
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
                    <strong>Category:</strong> {{ $post->category?->name ?? 'Uncategorized' }}
                </small><br>
                <small class="text-muted">
                    <strong>Author:</strong> {{ $post->user?->username ?? 'Unknown' }}
                    (Reputation: {{ $post->user?->reputationPoints ?? 0 }})
                </small>
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

            <!-- Edit and Delete Buttons (Only show for the post's author) -->
            @if (auth()->id() === $post->user_id)
                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                </form>
            @endif

            <!-- Comments Section -->
            <div class="mt-3">
                <h6>Comments:</h6>
                <ul class="list-group">
                    @forelse($post->comments as $comment)
                        <li class="list-group-item">
                            <strong>{{ $comment->user?->username ?? 'Unknown' }}:</strong> {{ $comment->content }}
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
@endforeach