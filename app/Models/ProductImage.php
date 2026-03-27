<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class ProductImage extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'product_id',
        'image_path',
    ];


 // Define the relationship with the Product model   
    public function product()
    {
         // Each product image belongs to one product
        return $this->belongsTo(Product::class);
    }
   
}
