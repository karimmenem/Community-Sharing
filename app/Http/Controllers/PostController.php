<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        // Eager load user, category, and votes
        $posts = Post::with(['user', 'category', 'votes'])->get();
        return view('posts.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'categoryId' => 'required|exists:categories,categoryId',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $validated['image'] = $path;
        }

        $post = Post::create($validated);

        // Redirect to posts.index (home page) after creating the post
        return redirect()->route('home')->with('success', 'Post created!');
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
