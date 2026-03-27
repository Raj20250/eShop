<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productImages = [
            // Laptop (ID: 1)
            ['product_id' => 1, 'image_path' => 'uploads/products/1773383397_69b3aee536060.png'],
            ['product_id' => 1, 'image_path' => 'uploads/products/1773383397_69b3aee5695b0.png'],
            
            // Headphones (ID: 2)
            ['product_id' => 2, 'image_path' => 'uploads/products/1773383581_69b3af9dc5cdc.png'],
            ['product_id' => 2, 'image_path' => 'uploads/products/1773383581_69b3af9dd30fd.png'],
            
            // Smart Watch (ID: 3)
            ['product_id' => 3, 'image_path' => 'uploads/products/1773383701_69b3b01592780.png'],
            ['product_id' => 3, 'image_path' => 'uploads/products/1773383701_69b3b01598acc.png'],
            
            // Webcam (ID: 4)
            ['product_id' => 4, 'image_path' => 'uploads/products/1773383833_69b3b09961f46.png'],
            ['product_id' => 4, 'image_path' => 'uploads/products/1773383833_69b3b099b941d.png'],
            
            // The Alchemist (ID: 9)
            ['product_id' => 9, 'image_path' => 'uploads/products/1773385412_69b3b6c4b3cce.png'],
            ['product_id' => 9, 'image_path' => 'uploads/products/1773385413_69b3b6c519300.png'],
            
            // Atomic Habits (ID: 10)
            ['product_id' => 10, 'image_path' => 'uploads/products/1773385474_69b3b702372da.png'],
            ['product_id' => 10, 'image_path' => 'uploads/products/1773385474_69b3b7028ce40.png'],
            
            // Think and Grow Rich (ID: 11)
            ['product_id' => 11, 'image_path' => 'uploads/products/1773385528_69b3b7381c4bd.png'],
            ['product_id' => 11, 'image_path' => 'uploads/products/1773385528_69b3b7382099e.png'],
            
            // LED Desk Lamp (ID: 12)
            ['product_id' => 12, 'image_path' => 'uploads/products/1773385672_69b3b7c83f3e6.png'],
            ['product_id' => 12, 'image_path' => 'uploads/products/1773385672_69b3b7c843c54.png'],
            
            // Plant Pot Set (ID: 13)
            ['product_id' => 13, 'image_path' => 'uploads/products/1773385723_69b3b7fbf0bdc.png'],
            ['product_id' => 13, 'image_path' => 'uploads/products/1773385724_69b3b7fc09b30.png'],
            
            // Coffee Maker (ID: 14)
            ['product_id' => 14, 'image_path' => 'uploads/products/1773385755_69b3b81b0bfd4.png'],
            ['product_id' => 14, 'image_path' => 'uploads/products/1773385755_69b3b81b0f79e.png'],
            
            // T-Shirt (ID: 5)
            ['product_id' => 5, 'image_path' => 'uploads/products/1773386705_69b3bbd1f28f3.PNG'],
            ['product_id' => 5, 'image_path' => 'uploads/products/1773386706_69b3bbd204aac.PNG'],
            
            // Jeans (ID: 6)
            ['product_id' => 6, 'image_path' => 'uploads/products/1773386757_69b3bc057f99c.PNG'],
            ['product_id' => 6, 'image_path' => 'uploads/products/1773386757_69b3bc0590e68.PNG'],
            
            // Sneakers (ID: 7)
            ['product_id' => 7, 'image_path' => 'uploads/products/1773386788_69b3bc24be8c7.PNG'],
            ['product_id' => 7, 'image_path' => 'uploads/products/1773386788_69b3bc24c4a56.PNG'],
            
            // Winter Jacket (ID: 8)
            ['product_id' => 8, 'image_path' => 'uploads/products/1773386891_69b3bc8be5352.PNG'],
            ['product_id' => 8, 'image_path' => 'uploads/products/1773386892_69b3bc8c55309.PNG'],
        ];

        DB::table('product_images')->insert($productImages);
    }
}