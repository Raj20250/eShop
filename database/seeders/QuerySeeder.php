<?php

namespace Database\Seeders;

use App\Models\Query;   
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuerySeeder extends Seeder
{   
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Query::create([
            'email' => 'raj@.com',
            'phone' => '+1234567890',
            'address' => '123 Main Street, Suite 100',
            'city' => 'Karachi',
            'country' => 'Pakistan',
            'description' => 'I have a question regarding the delivery of my order. It has been 3 days and I haven\'t received any update yet. Please help!',        ]);
    }
}
