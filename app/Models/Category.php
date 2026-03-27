<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{

// Specify the table name if it doesn't follow Laravel's naming convention
protected $table = 'categories';

// Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'slug',
        'status',

    ];
// Define the relationship with the Product model
    public function products()
    {
         // One category can have many products
        return $this->hasMany(Product::class);
    }
}
