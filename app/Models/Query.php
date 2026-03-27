<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'description',
        'reply',
    ];
}
