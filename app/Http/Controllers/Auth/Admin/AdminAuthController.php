<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{// Show the login form for admin users
    public function showLoginForm()
    {
        return view('auth.admin.login');
    }
// Handle the login request for admin users
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate using the admin guard
        if (Auth::guard('admin')->attempt($credentials)) {
            if (Auth::guard('admin')->user()->role !== 'admin') {
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Not an admin account']);
            }

            return redirect('admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid admin login']);
    }


     public function editProfile()
    {
        $user = Auth::guard('admin')->user();
        return view('auth.admin.edit-profile', compact('user'));
    }

    /**
     * Handle the profile update request (Name & Email)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('admin')->user();

        // Validation: Name must be at least 3 chars, email must be unique except for this user
        $request->validate([
            'name'  => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
// Update user profile with validated data
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Success redirection to Edit page
        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Handle password update logic
     */
    public function updatePassword(Request $request)
    {
        // Consistent validation: password min limit is 6, matching registration
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6',
        ]);
// Get currently authenticated user
        $user = Auth::guard('admin')->user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            // Failure redirection to Edit page with clear error message
            return redirect()->route('admin.profile.edit')->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }

        // Updating hashed password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Success redirection to Edit page
        return redirect()->route('admin.profile.edit')->with('success', 'Your password has been changed successfully!');
    }

    // Logout method to end admin session
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}

