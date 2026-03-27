<?php

namespace App\Models\Auth\Client;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Auth\Client\User;

class Wishlist extends Model
{
        // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'product_id',
    ];
 // Define the relationship to the User model
    public function user()
    {
         // Each wishlist item belongs to one user
        return $this->belongsTo(User::class);
    }

     // Define the relationship to the Product model
    public function product()
    {
         // Each wishlist item belongs to one product
        return $this->belongsTo(Product::class);
    }
}
