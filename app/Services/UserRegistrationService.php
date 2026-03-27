<?php
namespace App\Services;

use App\Models\Auth\Client\User; 
use Illuminate\Support\Facades\Hash;

class UserRegistrationService
{
    /**
     * Create a new user
     * Role defaults to 'client'
     */
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'client', // always client
        ]);
    }
}