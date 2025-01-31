<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
{
    // Fetch all categories
    $categories = Category::all();

    // Start building the query for posts
    $query = Post::with(['user', 'category', 'votes']);

    // Apply category filter
    if ($request->has('category') && $request->category != '') {
        $query->where('categoryId', $request->category);
    }

    // Apply sorting
    if ($request->has('sort')) {
        if ($request->sort == 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort == 'popular') {
            $query->withCount('votes')->orderBy('votes_count', 'desc');
        }
    }

    // Apply reputation filter
    if ($request->has('reputation')) {
        logger('Reputation Filter Value:', ['reputation' => $request->reputation]);
        if (is_numeric($request->reputation)) {
            $reputation = (int) $request->reputation;
            $query->whereHas('user', function ($q) use ($reputation) {
                $q->where('reputationPoints', '>=', $reputation);
            });
        } else {
            logger('Invalid Reputation Value:', ['reputation' => $request->reputation]);
        }
    }

    // Paginate posts
    $posts = $query->paginate(10); // Adjust the number as needed

    // Return the view with posts and categories
    return view('posts.index', compact('posts', 'categories'));
}


public function store(Request $request)
{
    // Validate incoming request
    $validated = $request->validate([
        'categoryId' => 'required|exists:categories,categoryId',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Debug: Log the validated data
    logger('Validated Data:', $validated);

    // Manually add the user_id from authenticated user
    $validated['user_id'] = auth()->id();

    // Handle image upload if there's one
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('posts', 'public');
        $validated['image'] = $path;
    }

    // Create the post with the validated data
    $post = Post::create($validated);

    // Debug: Log the created post
    logger('Created Post:', $post->toArray());

    return redirect()->route('posts.index')->with('success', 'Post created!');
}

public function show(Post $post)
{
    // Eager load the user relationship with reputationPoints
    $post->load(['user', 'category', 'comments.user', 'votes']);

    return view('posts.show', compact('post'));
}
public function edit(Post $post)
{
    // Ensure the authenticated user is the author of the post
    if (auth()->id() !== $post->user_id) {
        abort(403, 'Unauthorized action.'); // Return a 403 Forbidden error
    }

    $categories = Category::all(); // Fetch categories for the edit form
    return view('posts.edit', compact('post', 'categories'));
}

public function update(Request $request, Post $post)
{
    // Ensure the authenticated user is the author of the post
    if (auth()->id() !== $post->user_id) {
        abort(403, 'Unauthorized action.'); // Return a 403 Forbidden error
    }

    // Validate incoming data
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'categoryId' => 'required|exists:categories,categoryId',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Handle image update
    if ($request->hasFile('image')) {
        // Delete old image if it exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $path = $request->file('image')->store('posts', 'public');
        $validated['image'] = $path;
    }

    // Update the post with the validated data
    $post->update($validated);

    // Redirect to posts.index with a success message
    return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
}

public function destroy(Post $post)
{
    // Ensure the authenticated user is the author of the post
    if (auth()->id() !== $post->user_id) {
        abort(403, 'Unauthorized action.'); // Return a 403 Forbidden error
    }

    // Delete the post's image if it exists
    if ($post->image) {
        Storage::disk('public')->delete($post->image);
    }

    // Delete the post
    $post->delete();

    return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
}
    public function search(Request $request)
{
    $query = $request->input('query');

    // Fetch categories to fix the undefined variable error
    $categories = Category::all();

    $posts = Post::with(['user', 'category', 'votes'])
        ->where('title', 'like', "%$query%")
        ->orWhere('description', 'like', "%$query%")
        ->orWhereHas('user', function ($q) use ($query) {
            $q->where('username', 'like', "%$query%");
        })
        ->paginate(10); // Paginate for consistency

    return view('posts.index', compact('posts', 'categories'));
}


    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('posts.create', compact('categories'));
    }
}
