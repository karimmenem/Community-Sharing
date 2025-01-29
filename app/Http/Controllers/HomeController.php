<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // If the user is authenticated, show the posts index page
        if (auth()->check()) {
            $posts = Post::with(['user', 'category', 'votes'])->latest()->get();
            return view('posts.index', compact('posts'));
        }

        // If the user is not authenticated, show the welcome page
        return view('welcome');
    }
}