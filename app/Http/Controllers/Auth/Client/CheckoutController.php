<?php

namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout page with cart items.
     */
    public function index(Request $request)
    {
        $cart = CartService::getCart($request);
        
        if (empty($cart)) {
            return redirect()->route('carts')->with('error', 'Your cart is empty');
        }

        $total = 0;
        $items = [];
        
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $total += $itemTotal;
                $items[$productId] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
            }
        }

        return view('auth.client.checkout', [
            'items' => $items,
            'total' => $total,
            'user' => Auth::user()
        ]);
    }

    /**
     * Place order with database transaction.
     */
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'shipping_address' => 'required|string',
        ]);
// Get cart items
        $cart = CartService::getCart($request);

        if (empty($cart)) {
            return redirect()->route('carts')->with('error', 'Cart is empty');
        }

        // Use transaction to ensure data integrity
        DB::transaction(function () use ($cart, $validated, &$order) {

        // Calculate total amount
            $total = 0;
            $orderItemsData = []; // To hold order items data for bulk insert

            // Prepare order items & calculate total
            foreach ($cart as $productId => $item) {
                $product = Product::findOrFail($productId);
                $itemTotal = $product->price * $item['quantity'];
                $total += $itemTotal;
// Prepare order item data
                $orderItemsData[] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $itemTotal
                ];
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . time(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => 'offline',
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
            ]);

            // Save order items
            foreach ($orderItemsData as $itemData) {
                $itemData['order_id'] = $order->id;
                OrderItem::create($itemData);
            }

            // Clear the cart (Cart status will become completed)
            CartService::clearCart();
        });

        // Redirect to success page with order ID
        return redirect()->route('order.success', ['order' => $order->id])
            ->with('success', 'Order placed successfully!');
    }

    /**
     * Show order success page.
     */
    public function orderSuccess(Request $request)
    {    // Get order ID from query parameter
        $orderId = $request->query('order');
        $order = Order::findOrFail($orderId);
// Ensure the order belongs to the authenticated user
        if ($order->user_id && $order->user_id !== Auth::id()) {
            return redirect()->route('home')->with('error', 'Unauthorized');
        }
// Show order details on success page
        return view('auth.client.order-success', ['order' => $order]);
    }
}