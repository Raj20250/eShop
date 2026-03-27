<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'category_id' => 1,
                'name' => 'High-Performance Laptop',
                'slug' => 'high-performance-laptop',
                'description' => 'Powerful laptop with 16GB RAM and 512GB SSD perfect for professionals',
                'price' => 999.99,
                'stock' => 15,
                'status' => 'active',
                'image' => 'uploads/products/1773383397_main.png',
            ],
            [
                'category_id' => 1,
                'name' => 'Wireless Headphones',
                'slug' => 'wireless-headphones',
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life',
                'price' => 199.99,
                'stock' => 45,
                'status' => 'active',
                'image' => 'uploads/products/1773383581_main.png',

            ],
            [
                'category_id' => 1,
                'name' => 'Smart Watch',
                'slug' => 'smart-watch',
                'description' => 'Advanced fitness tracker with heart rate monitor and GPS',
                'price' => 299.99,
                'stock' => 30,
                'status' => 'active',
                'image' => 'uploads/products/1773383701_main.png',
            ],
            [
                'category_id' => 1,
                'name' => '4K Webcam',
                'slug' => '4k-webcam',
                'description' => 'Crystal clear 4K resolution webcam for streaming and video calls',
                'price' => 129.99,
                'stock' => 20,
                'status' => 'active',
                'image' => 'uploads/products/1773383833_main.png',
            ],
            
            // Apparel
            [
                'category_id' => 2,
                'name' => 'Premium Cotton T-Shirt',
                'slug' => 'premium-cotton-tshirt',
                'description' => '100% organic cotton t-shirt available in multiple colors',
                'price' => 29.99,
                'stock' => 100,
                'status' => 'active',
                'image' => 'uploads/products/1773386276_main.PNG',
            ],
            [
                'category_id' => 2,
                'name' => 'Denim Jeans',
                'slug' => 'denim-jeans',
                'description' => 'Classic blue denim jeans with perfect fit and comfort',
                'price' => 79.99,
                'stock' => 50,
                'status' => 'active',
                'image' => 'uploads/products/1773384538_main.png',
            ],
            [
                'category_id' => 2,
                'name' => 'Casual Sneakers',
                'slug' => 'casual-sneakers',
                'description' => 'Comfortable everyday sneakers with superior grip and cushioning',
                'price' => 89.99,
                'stock' => 35,
                'status' => 'active',
                'image' => 'uploads/products/1773385222_main.png',
            ],
            [
                'category_id' => 2,
                'name' => 'Winter Jacket',
                'slug' => 'winter-jacket',
                'description' => 'Warm waterproof winter jacket with thermal lining',
                'price' => 149.99,
                'stock' => 25,
                'status' => 'active',
                'image' => 'uploads/products/1773385320_main.png',
            ],
            
            // Books
        
 [
    'category_id' => 3,
    'name' => 'The Alchemist',
    'slug' => 'the-alchemist-fable',
    'description' => 'A magical story about following your dreams and listening to your heart.',
    'price' => 12.99,
    'stock' => 50,
    'status' => 'active',
    'image' => 'uploads/products/1773385412_main.png',
],
[
    'category_id' => 3,
    'name' => 'Atomic Habits',
    'slug' => 'atomic-habits-clear',
    'description' => 'An easy and proven way to build good habits and break bad ones.',
    'price' => 18.50,
    'stock' => 35,
    'status' => 'active',
    'image' => 'uploads/products/1773385474_main.png',
],
[
    'category_id' => 3,
    'name' => 'Think and Grow Rich',
    'slug' => 'think-and-grow-rich-hill',
    'description' => 'The landmark bestseller by Napoleon Hill on personal success and wealth.',
    'price' => 15.00,
    'stock' => 20,
    'status' => 'active',
    'image' => 'uploads/products/1773385527_main.png',
],
            
            // Home & Garden
            [
                'category_id' => 4,
                'name' => 'LED Desk Lamp',
                'slug' => 'led-desk-lamp',
                'description' => 'Adjustable LED desk lamp with multiple brightness levels',
                'price' => 39.99,
                'stock' => 70,
                'status' => 'active',
                'image' => 'uploads/products/1773385672_main.png',
            ],
            [
                'category_id' => 4,
                'name' => 'Plant Pot Set',
                'slug' => 'plant-pot-set',
                'description' => 'Set of 5 ceramic plant pots in various sizes',
                'price' => 34.99,
                'stock' => 80,
                'status' => 'active',
                'image' => 'uploads/products/1773385723_main.png',
            ],
            [
                'category_id' => 4,
                'name' => 'Coffee Maker',
                'slug' => 'coffee-maker',
                'description' => 'Automatic coffee maker with programmable timer',
                'price' => 69.99,
                'stock' => 15,
                'status' => 'active',
                'image' => 'uploads/products/1773385755_main.png',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
