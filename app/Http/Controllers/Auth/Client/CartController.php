<?php

namespace App\Http\Controllers\Auth\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        return view('auth.client.carts');
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {     // Validate product ID and quantity
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);
//         Add product to cart with specified quantity (default to 1 if not provided)
        $quantity = $validated['quantity'] ?? 1;
        CartService::addToCart($validated['product_id'], $quantity, $request);
 //         Return response
        return response()->json([
            'message' => 'Product added to cart',
            'cartCount' => CartService::getCartCount($request),
        ], 200);
    }

    /**
     * Update cart item
     */
    public function updateCart(Request $request)
    {       // Validate product ID and quantity
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:0',
        ]);

/** update cart item quantity. If quantity is 0, it will remove the item from cart.
*/
        CartService::updateCartItem($validated['product_id'], $validated['quantity'], $request);
//         Return response
        return response()->json([
            'message' => 'Cart updated',
            'cartCount' => CartService::getCartCount($request),
        ], 200);
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request)
    {     // Validate product ID
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);
//         Remove item from cart
        CartService::removeFromCart($validated['product_id'], $request);
//         Return response
        return response()->json([
            'message' => 'Item removed from cart',
            'cartCount' => CartService::getCartCount($request),
        ], 200);
    }

    /**
     * Clear all cart
     */
    public function clearCart()
    {   // Clear cart from session
        CartService::clearCart();
//         Clear cart and return response
        return response()->json([
            'message' => 'Cart cleared',
            'cartCount' => 0,
        ], 200);
    }

    /**
     * Get cart items
     */
    public function getCart(Request $request)
{
    // Get cart from session
    $cart = CartService::getCart($request); // session cart
//      If cart is empty, return empty response
    if (empty($cart)) {
        return response()->json([
            'cart' => [],
            'cartCount' => 0,
        ], 200);
    }
//     Get product IDs from cart
    $productIds = array_keys($cart);
//     Fetch product details from database
    $products = Product::whereIn('id', $productIds)
        ->select('id', 'name', 'price', 'image')
        ->get()
        ->keyBy('id');
//      Format cart items for response 
    $formattedCart = [];
    $totalItems = 0;



    // Format cart items for response
   foreach ($cart as $productId => $item) {
        if (!isset($products[$productId])) continue;
//         Get product details
        $product = $products[$productId];
        $quantity = $item['quantity'];
        $itemTotal = $product->price * $quantity;
//         Format cart item for response
        $formattedCart[$productId] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'image' => $product->image,
            'quantity' => $quantity,
            'total' => $itemTotal,
        ];
 //         Calculate total items in cart
        $totalItems += $quantity;
    }
//     Return formatted cart and total item count
    return response()->json([
        'cart' => $formattedCart,
        'cartCount' => $totalItems,
    ], 200);
}

}
