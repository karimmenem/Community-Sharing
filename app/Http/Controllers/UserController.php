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
    // In UserController.php

// Show User Dashboard
public function dashboard()
{
    $user = auth()->user();
    $posts = $user->posts;
    $comments = $user->comments;
    return view('user.dashboard', compact('user', 'posts', 'comments'));
}

// Show Profile Edit Form
public function editProfile()
{
    $user = auth()->user();
    return view('user.edit-profile', compact('user'));
}

// Update Profile
public function updateProfile(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'username' => 'required|string|max:50|unique:users,username,' . $user->id,
        'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
    ]);

    $user->update($validated);
    return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully.');
}

// Show Change Password Form
public function showChangePasswordForm()
{
    return view('user.change-password');
}

// Change Password
public function changePassword(Request $request)
{
    $user = auth()->user();

    $validated = $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Verify current password
    if (!Hash::check($validated['current_password'], $user->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Update password
    $user->update([
        'password' => Hash::make($validated['new_password']),
    ]);

    return redirect()->route('user.dashboard')->with('success', 'Password changed successfully.');
}

    public function logout()
{
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
}
}
