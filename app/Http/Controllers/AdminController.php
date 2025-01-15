<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        $userCount = User::count(); // Total number of users
        $postCount = Post::count(); // Total number of posts
        return view('admin.dashboard', compact('userCount', 'postCount'));
    }

    // Manage Users
    public function manageUsers()
    {
        $users = User::all(); // Fetch all users
        return view('admin.manage-users', compact('users'));
    }

    // Manage Posts
    public function managePosts()
    {
        $posts = Post::with('user')->get(); // Fetch all posts with their authors
        return view('admin.manage-posts', compact('posts'));
    }

    // Delete a User
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.manageUsers')->with('success', 'User deleted successfully.');
    }

    // Delete a Post
    public function deletePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->route('admin.managePosts')->with('success', 'Post deleted successfully.');
    }
}
