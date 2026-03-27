<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Client\User;

class Cart extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = ['user_id', 'status'];
    
    // Define the relationship with the User model
    public function user()
    {
        // Define the relationship with the User model
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the CartItem model
    public function items()
    {
        // Define the relationship with the CartItem model
        return $this->hasMany(CartItem::class);
    }
}
