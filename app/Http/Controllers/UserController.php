<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function register(Request $request)
{
    // Validate the incoming request
    $validated = $request->validate([
        'username' => 'required|string|max:50|unique:users',
        'email' => 'required|string|email|max:100|unique:users',
        'password' => 'required|string|min:8|confirmed', // Ensure password confirmation
    ]);

    // Hash the password
    $validated['password'] = Hash::make($validated['password']);

    // Create the user
    $user = User::create($validated);

    // Log in the user
    Auth::login($user);

    // Redirect to the desired page (e.g., the user's dashboard)
    return redirect()->route('user.dashboard')->with('success', 'Registration successful!');
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
    // Show User Dashboard
    public function dashboard()
    {
        $user = auth()->user();
        $posts = $user->posts ?? collect(); // Ensure no error if relation doesn't exist
        $comments = $user->comments ?? collect();
        
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

        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users,username,' . $user->id,
                'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            ]);

            $user->update($validated);
            return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }

    // Show Change Password Form
    public function showChangePasswordForm()
{
    return view('auth.passwords.change-password');
}

    // Change Password
    public function changePassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'current_password' => 'required',
        'new_password' => 'required|string|min:8',
    ]);

    // Find the user by email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'The provided email does not match our records.']);
    }

    // Verify the current password
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    // Update the password
    $user->update([
        'password' => Hash::make($request->new_password),
    ]);

    return redirect()->route('welcome')->with('success', 'Password changed successfully.');
}

    public function logout()
    {
        $request = request();
        Auth::logout();
        $request->session()->invalidate(); // Invalidate before regenerating
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
