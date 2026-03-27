<?php
namespace App\Http\Controllers\Auth\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Client\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index ()
    {
       // $user = auth()->user();

        /** @var \App\Models\Auth\Client\User $user */
         $user = Auth::guard('web')->user();
        $wishlist = $user->wishlist()->with('product.category')->get();
        
        return view('auth.client.wishlist', [
            'wishlist' => $wishlist
        ]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

         //$user = auth()->user();
           /** @var \App\Models\Auth\Client\User $user */
         $user = Auth::guard('web')->user();
        
        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
                          ->where('product_id', $request->product_id)
                          ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlistCount' => $user->wishlist()->count()
        ]);
    }



    public function remove(Request $request)
{
    // Validate that the product exists
    $request->validate([
        'product_id' => 'required|exists:products,id'
    ]);

    /** @var \App\Models\Auth\Client\User $user */
    $user = Auth::guard('web')->user();
    
    // Delete the item from the wishlist
    Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->delete();

    // If it's an AJAX request, return JSON
    if ($request->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlistCount' => $user->wishlist()->count()
        ]);
    }

    // Standard Form Redirect with Success Message
    return redirect()->back()->with('success', 'Product removed from wishlist successfully!');
}
}
