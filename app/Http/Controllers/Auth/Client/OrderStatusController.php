<?php
namespace App\Http\Controllers\Auth\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderStatusController extends Controller
{
    public function index (){
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        return view('auth.client.order-history', compact('user', 'orders'));
    }
}
