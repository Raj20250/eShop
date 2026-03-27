<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\UserRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientAuthController extends Controller
{      // Dependency injection of UserRegistrationService for better separation of concerns
     protected $userService;
// Constructor to initialize the UserRegistrationService
    public function __construct(UserRegistrationService $userService)
    {
        $this->userService = $userService;
    }
// Show the registration form for client users
    public function showRegisterForm()
    {
        return view('auth.client.register');
    }

    // Handle the registration request for client users
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            // Email must be unique in users table to prevent duplicate accounts
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:6|confirmed',
        ]);

        $this->userService->createUser($request->all());

        return redirect()->route('login')->with('success', 'Account created');
    }
    public function showLoginForm()
    {
        return view('auth.client.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'client') {
                $request->session()->regenerate();
                CartService::migrateGuestCartToUser($request);
                return redirect()->route('home'); 
            }
            Auth::logout();
            return back()->withErrors(['email' => 'Not a client account']);
        }
        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials']);
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('auth.client.edit-profile', compact('user'));
    }

    /**
     * Handle the profile update request (Name & Email)
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validation: Name must be at least 3 chars, email must be unique except for this user
        $request->validate([
            'name'  => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Success redirection to Edit page
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
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

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            // Failure redirection to Edit page with clear error message
            return redirect()->route('profile.edit')->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }

        // Updating hashed password
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Success redirection to Edit page
        return redirect()->route('profile.edit')->with('success', 'Your password has been changed successfully!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}