<?php

namespace App\Models\Auth\Client;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Order;
use App\Models\Auth\Client\Wishlist;
use App\Models\Cart;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

     // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

     // Define the hidden attributes for serialization
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

     // Define the casts for the model attributes
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     // Define the relationship to the Order model
    public function orders()
    {
         // One user can have many orders
        return $this->hasMany(Order::class);
    }

     // Define the relationship to the Wishlist model
    public function wishlist()
    {
         // One user can have many wishlist items
        return $this->hasMany(Wishlist::class);
    }

 // Define the relationship to the Cart model
public function cart()
{
     // One user has one cart
    return $this->hasOne(Cart::class);
}

}
