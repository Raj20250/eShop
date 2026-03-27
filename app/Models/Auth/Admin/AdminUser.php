<?php

namespace App\Models\Auth\Admin;

// Importing the HasFactory trait to allow the use of factories for testing and seeding
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Importing Authenticatable to provide authentication features to this model
use Illuminate\Foundation\Auth\User as Authenticatable;

// Importing Notifiable to allow this model to receive system notifications
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    // Adding the HasFactory trait to fix the "Call to undefined method" error
    // Adding Notifiable to enable email/database notifications for admins
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     * @var array<int, string>
     */
        // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * @var array<int, string>
     */

     // Define the hidden attributes for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Automatically hashes the password when saved
    ];
}