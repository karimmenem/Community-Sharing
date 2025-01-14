<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
{
    $posts = Post::with(['user', 'category'])->get(); // Fetch posts with relationships
    return view('posts.index', compact('posts')); // Pass posts data to the Blade view
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'userId' => 'required|exists:users,userId',
            'categoryId' => 'required|exists:categories,categoryId',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post = Post::create($validated);
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }

    public function show($id)
{
    $post = Post::with(['user', 'category', 'comments', 'votes'])->findOrFail($id);
    return view('posts.show', compact('post'));
}

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->only('title', 'description'));

        return response()->json(['message' => 'Post updated successfully', 'post' => $post], 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
