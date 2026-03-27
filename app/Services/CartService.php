<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartService
{
    const SESSION_KEY = 'cart_items';

    /* ----------------------------------------
     | Add To Cart
     ---------------------------------------- */
    public static function addToCart($productId, $quantity = 1, Request $request = null)
    {
        if (Auth::check()) {
// Get or create the active cart for the authenticated user
            $cart = self::getOrCreateActiveCart();
            $product = Product::findOrFail($productId);
// Check if the product is already in the cart
            $item = $cart->items()->where('product_id', $productId)->first();
// If it exists, update the quantity; otherwise, create a new cart item
            if ($item) {
                $item->quantity += $quantity;
                $item->save();
            } else {
                // Create a new cart item with the current price of the product
                $cart->items()->create([
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price_at_that_time' => $product->price,
                ]);
            }

        } else {

        // For guests, store cart items in the session
            $cart = Session::get(self::SESSION_KEY, []);
// If the product is already in the session cart, update the quantity; otherwise, add a new entry
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                // Add new product to session cart
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ];
            }
// Save the updated cart back to the session
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    /* ----------------------------------------
     | Update Item
     ---------------------------------------- */
    public static function updateCartItem($productId, $quantity, Request $request = null)
    {
        if (Auth::check()) {
// Get the active cart for the authenticated user
            $cart = self::getOrCreateActiveCart();
            $item = $cart->items()->where('product_id', $productId)->first();

            if ($item) {
                // If quantity is zero or less, remove the item; otherwise, update the quantity
                if ($quantity <= 0) {
                    $item->delete();
                } else {
                    // Update the quantity of the existing cart item
                    $item->quantity = $quantity;
                    $item->save();
                }
            }

        } else {
// For guests, update the session cart
            $cart = Session::get(self::SESSION_KEY, []);
// If the product exists in the session cart, update or remove it based on the quantity
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                // Update the quantity of the existing product in the session cart
                $cart[$productId]['quantity'] = $quantity;
            }
// Save the updated cart back to the session
            Session::put(self::SESSION_KEY, $cart);
        }
    }

    // Remove from cart (set quantity to 0)
    public static function removeFromCart($productId, Request $request = null)
    {
        // Simply call updateCartItem with quantity 0 to remove the item from the cart
        self::updateCartItem($productId, 0, $request);
    }

    /* ----------------------------------------
     | Clear Cart
     ---------------------------------------- */
    public static function clearCart()
    {
        if (Auth::check()) {
// For authenticated users, mark the current active cart as completed (or you could choose to delete it)
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();
// Mark the cart as completed instead of deleting it to keep order history
            if ($cart) {
                $cart->status = 'completed';
                $cart->save();
            }
//
        } else {
            // For guests, simply clear the session cart
            Session::forget(self::SESSION_KEY);
        }
    }

    /* ----------------------------------------
     | Get Cart
     ---------------------------------------- */
    public static function getCart(Request $request = null)
    {
        if (Auth::check()) {
// For authenticated users, retrieve the active cart and its items from the database
            $cart = Cart::where('user_id', Auth::id())
                ->where('status', 'active')
                ->with('items')
                ->first();
// If no active cart exists, return an empty array
            if (!$cart) return [];
// Format the cart items into a consistent structure for the frontend
            $formatted = [];
// Loop through the cart items and format them for the frontend
            foreach ($cart->items as $item) {
                $formatted[$item->product_id] = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ];
            }
// Return the formatted cart items for authenticated users
            return $formatted;

        } else {
// For guests, retrieve the cart items from the session
            return Session::get(self::SESSION_KEY, []);
        }
    }

    /* ----------------------------------------
     | Count
     ---------------------------------------- */
    public static function getCartCount(Request $request = null)
    {
        //  Retrieve the cart items and count the total quantity of items in the cart
        $cart = self::getCart($request);
        $count = 0;
// Loop through the cart items and sum up the quantities to get the total count
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
// Return the total count of items in the cart
        return $count;
    }

    /* ----------------------------------------
     | Private Helper
     ---------------------------------------- */
    private static function getOrCreateActiveCart()
    {
        // Retrieve the active cart for the authenticated user or create a new one if it doesn't exist
        return Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'active'
            ]
        );
    }

    /* ----------------------------------------
     | Migrate Guest Cart To User Cart
     ---------------------------------------- */
    public static function migrateGuestCartToUser(Request $request)
    {
        // Only migrate if the user is authenticated; if not, there's no cart to migrate
        if (!Auth::check()) return;
// Retrieve the guest cart from the session 
        $guestCart = Session::get(self::SESSION_KEY, []);
// If there are items in the guest cart, migrate them to the authenticated user's cart
        if (!empty($guestCart)) {
            $cart = self::getOrCreateActiveCart();
// Loop through each item in the guest cart and add it to the authenticated user's cart
            foreach ($guestCart as $productId => $item) {
                $cartItem = $cart->items()->where('product_id', $productId)->first();
                if ($cartItem) {
                    $cartItem->quantity += $item['quantity'];
                    $cartItem->save();
                } else {
                    // Create a new cart item with the current price of the product
                    $cart->items()->create([
                        'product_id' => $productId,
                        'quantity' => $item['quantity'],
                        'price_at_that_time' => Product::find($productId)->price,
                    ]);
                }
            }

            // Clear guest session cart
            Session::forget(self::SESSION_KEY);
        }
    }
}