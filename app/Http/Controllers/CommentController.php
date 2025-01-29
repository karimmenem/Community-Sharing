<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Store a new comment
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    // Delete a comment
    public function destroy(Comment $comment)
    {
        // Ensure the user can only delete their own comments
        if ($comment->user_id !== auth()->id()) {
            return back()->with('error', 'You are not authorized to delete this comment.');
        }

        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}