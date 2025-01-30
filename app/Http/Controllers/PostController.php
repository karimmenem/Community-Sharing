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
    // Eager load relationships
    $post->load(['user', 'category', 'comments', 'votes']);
    return view('posts.show', compact('post'));
}

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post->update($validated);
        return redirect()->route('posts.show', $post)->with('success', 'Post updated!');
    }

    public function destroy(Post $post)
    {
        // Delete the post
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $posts = Post::with(['user', 'category', 'votes'])
            ->where('title', 'like', "%$query%")
            ->orWhere('description', 'like', "%$query%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('username', 'like', "%$query%");
            })
            ->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all(); // Fetch all categories
        return view('posts.create', compact('categories'));
    }
}
