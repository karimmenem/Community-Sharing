<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|confirmed', // Ensure password confirmation
        ]);

        // Hash the password here after validation
        $validated['password'] = Hash::make($validated['password']);
        
        // Create user with the validated data
        $user = User::create($validated);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Redirect based on role
        if (Auth::user()->role === 'Admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('posts.index');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}

    

    // Get User Profile
    public function getUserProfile($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    // Update User Profile
    public function updateUserProfile(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'email' => 'required|string|email|max:100|unique:users,email,' . $id,
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Update the user details
        $user->update($validated);

        return response()->json(['message' => 'User profile updated successfully', 'user' => $user], 200);
    }

    // Change Password
    public function changePassword(Request $request, $id)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Verify the current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        // Update the password
        $user->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json(['message' => 'Password changed successfully'], 200);
    }

    // Get User Posts (Assuming the user has a "posts" relationship)
    public function getUserPosts($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $posts = $user->posts; // Assuming a relationship named "posts"
        return response()->json(['posts' => $posts], 200);
    }
}
