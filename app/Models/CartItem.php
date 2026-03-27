<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class CartItem extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price_at_that_time',
    ];

    // Define the relationship with the Cart model
    public function cart()
    {
         // Each cart item belongs to one cart
        return $this->belongsTo(Cart::class);
    }

    // Define the relationship with the Product model
    public function product()
    {
         // Each cart item belongs to one product
        return $this->belongsTo(Product::class);
    }
}
