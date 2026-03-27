<?php
namespace App\Http\Controllers\Auth\Admin;



use App\Http\Controllers\Controller;
// Using Client models for Admin operations
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //  Display all orders with search and status filters
    public function index(Request $request)
    {
        //  Initialize query with user relationship
        $query = Order::with('user');

        //  Filter by status (Pending, Processing, etc.)
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search logic for Order Number or Customer Name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('order_number', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('customer_name', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Fetch paginated results
        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('auth.admin.show-order', compact('orders'));
    }

    // Show all order history for a specific customer
    public function show(string $id)
    {
    
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);

        // Passing the order object to the detail view
        return view('auth.admin.show-single-order', compact('order'));
    }
    
    
        

    //  New Method to update order status from the dropdown
        public function update(Request $request, string $id)
    {
        //  Validate the status input
    $request->validate([
        'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled'
    ]);

    //  Find the order and update the status
    $order = Order::findOrFail($id);
    $order->status = $request->order_status;
    $order->save();

    // Return back with success message
    return back()->with('success', 'Status updated to ' . $request->order_status);
    }
    
     

    // Remove the specified order from database
    public function destroy(string $id)
    {
        // Find the order and delete it
        $order = Order::findOrFail($id);
        $order->delete();
// Return back with success message
        return back()->with('success', 'Order deleted successfully!');
    }
}