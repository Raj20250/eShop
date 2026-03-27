<?php
// tests/Feature/Auth/LoginTest.php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; // User model ki zaroorat

class LoginTest extends TestCase
{
    // Database ko saaf karne ke liye zaruri (Isolation Principle)
    use RefreshDatabase; 

    /**
     * @test
     * Test Case 1: Kamyab Login ka test
     */
    public function a_user_can_login_with_correct_credentials_and_is_redirected()
    {
        // 1. ARRANGE (Setup)
        // Aik user database mein pehle se banaein jise hum login karwayenge.
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'), // Laravel mein passwords hash hote hain
        ]);

        // 2. ACT (Amal)
        // POST request bhejain jise button dabane ka amal simulate karna hai.
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password123', // Raw password bhejte hain
        ]);
        
        // 3. ASSERT (Tasdeeq)

        // A. Response Check: Kya redirection welcome page par hui?
        // Hum route('welcome') ya phir uski URL (maslan '/') ka istemal kar sakte hain
        $response->assertRedirect(route('home')); 

        // B. Auth Check: Kya user asal mein login ho gaya?
        $this->assertAuthenticatedAs($user); 
    }
    
    /**
     * @test
     * Test Case 2: Na-Kamyab Login ka test (Invalid Password)
     */
    public function a_user_cannot_login_with_incorrect_password()
    {
        // 1. ARRANGE (Setup)
        $user = User::factory()->create([
            'email' => 'client@example.com',
            'password' => bcrypt('nnnnnnnn'),
        ]);

        // 2. ACT (Amal)
        // Ghalat password bhejain.
        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password', // Ghalat password
        ]);
        
        // 3. ASSERT (Tasdeeq)

        // A. Status Check: Login fail hone par wapis login page par redirect hona chahiye.
        $response->assertRedirect(route('login')); 

        // B. Auth Check: Kya user login nahi hua?
        $this->assertGuest(); 
        
        // C. Session Check: Kya session mein 'error' message aaya? (Optional, agar aap session('error') check kar rahe hain)
        // Hum session mein aane wali ghaltiyon ko bhi check kar sakte hain.
        // Agar aap custom validation use kar rahe hain to yeh check lazmi hai
        // $response->assertSessionHas('error'); 
    }
}