<?php
namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;


class OrderHistoryController extends Controller
{
    public function index ()
    {
        

        /** @var \App\Models\Auth\Client\User $user */
         $user = Auth::guard('web')->user();

        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        
        return view('auth.client.order-history', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    public function show($id)
    {    // Show order details for a specific order ID with authorization check
        $order = Order::with('products')->findOrFail($id);

        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('auth.client.order-detail', [
            'order' => $order,
            'products' => $order->products
        ]);
    }
}
