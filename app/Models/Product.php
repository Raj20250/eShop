<?php

namespace App\Models;

use App\Models\Auth\Client\wishlist;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    // Define the fillable attributes for mass assignment

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image',
        'status',
    ];
// Define the relationship with the Category model
    public function category()
    {
         // Each product belongs to one category
        return $this->belongsTo(Category::class);
    }
// Define the relationship with the OrderItem model
    public function wishlists()
    {
         // One product can be in many wishlists
        return $this->hasMany(Wishlist::class);
    }
// Define the relationship with the ProductImage model
    public function product_images(): HasMany
    {
        // One product has many images
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    }

