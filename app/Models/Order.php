<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\Client\User;
use App\Models\OrderItem;
use App\Models\Product;

class Order extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'payment_method',
        'transaction_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
    ];

    //  Define the relationship with the User model
    public function user()
    {
         // Each order belongs to one user
        return $this->belongsTo(User::class);
    }

    // Define the relationship with the OrderItem model
    public function orderitems()
    {
         // One order can have many order items
        return $this->hasMany(OrderItem::class);
    }

    // Define the relationship with the Product model through OrderItem
public function products()
{
    // This allows you to access products directly from the Order model
    return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
                ->withPivot('quantity', 'price'); // Include extra columns from pivot table
}
    }

