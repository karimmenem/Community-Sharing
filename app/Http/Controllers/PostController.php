<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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
        // Validate incoming data
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'categoryId' => 'required|exists:categories,categoryId',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create the new post
        $post = Post::create($validated);
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function show($id)
    {
        // Eager load user, category, comments, and votes
        $post = Post::with(['user', 'category', 'comments', 'votes'])->findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function update(Request $request, $id)
    {
        // Validate updated data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Find the post by ID and update it
        $post = Post::findOrFail($id);
        $post->update($validated);

        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
    }

    public function destroy($id)
    {
        // Find the post and delete it
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
