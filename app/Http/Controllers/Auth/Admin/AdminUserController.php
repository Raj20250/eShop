<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Auth\Admin\AdminUser;
use App\Services\UserRegistrationService;
use App\Models\Auth\Client\User; 
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // 1️⃣ List all users
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = User::query();

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
        }

        $users = $query->paginate(10);
        return view('auth.admin.show-total-user', compact('users'));
    }

 protected $userService;

    public function __construct(UserRegistrationService $userService)
    {
        // Dependency injection of UserRegistrationService for better separation of concerns
        $this->userService = $userService;
    }

    // 2️⃣ Show create user form
    public function create()
    {
        return view('auth.admin.create-user');
    }

    // Handle create user request
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            //
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $this->userService->createUser($request->all());

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // 4️⃣ Show single user
    public function show(string $id)
    {
        $user = AdminUser::findOrFail($id);
        return view('auth.admin.view-user', compact('user'));
    }

    // 5️⃣ Show edit form
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('auth.admin.edit-user', compact('user'));
    }

    // 6️⃣ Update user
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // 7️⃣ Delete user
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}