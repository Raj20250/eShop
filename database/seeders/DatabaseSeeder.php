<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\Admin\AdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        AdminUser::factory()->create([
            'name' => 'Raj',
            'email' => 'raj@gmail.com',
             'role'  => 'client', // Assigning role as 'client'
             'password' => Hash::make('password')
             
        ]);


        AdminUser::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'role'  => 'admin', // Assigning role as 'admin'
             'password' => Hash::make('password')

            ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ProductImageSeeder::class,
            QuerySeeder::class,
        ]);
    }
}
