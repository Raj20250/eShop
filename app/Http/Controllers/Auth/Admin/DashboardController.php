<?php

namespace App\Http\Controllers\Auth\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Category;

class DashboardController extends Controller
{
    // Display pending orders on the admin dashboard

    public function index()
    {
        $pendingOrders = Order::where('status', 'pending')->latest()->take(10)->get();
        $pendingCount = Order::where('status', 'pending')->count();
        $totalOrders = Order::count();

        // Calculate total revenue from orders table
        $totalRevenue = Order::sum('total_amount');

        // Calculate total categories
        $totalCategories = Category::count();

        return view('auth.admin.admin-dashboard', compact('pendingOrders', 'pendingCount', 'totalOrders', 'totalRevenue', 'totalCategories'));
    }

    //  Display details of a specific order including products
    
    public function show(string $id)
    {
        // Fetch order with its items and related products
      
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);

        //  Passing the order object to the detail view
        
        return view('auth.admin.show-pendding-single-order', compact('order'));
    }

    //  Update the status of an order
    
    public function update(Request $request, string $id)
    {
        // Validate the status input
    
    $request->validate([
        'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled'
    ]);

    // Find the order and update the status
    
    $order = Order::findOrFail($id);
    $order->status = $request->order_status;
    $order->save();

    // Return back with success message
    return back()->with('success', 'Status updated to ' . $request->order_status);
    }

    //  Delete an order from the database
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
// Return back with success message after deletion
        return back()->with('success', 'Order deleted successfully!');
    }
}