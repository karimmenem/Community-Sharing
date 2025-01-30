<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
    

        // If the user is not authenticated, show the welcome page
        return view('welcome');
    }
}