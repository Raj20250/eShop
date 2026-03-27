@extends('layouts.client.client-main')

@section('title', 'My Wishlist - E-Shop')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-pink-600 mb-8 border-b pb-4">My Wishlist</h1>

    @if($wishlist->count() > 0)
    <div class="space-y-4">
        @foreach($wishlist as $item)
        <div class="flex items-center bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-150">
            <div class="w-16 h-16 bg-gray-200 mr-4 flex items-center justify-center shrink-0">
                @if($item->product->image)
                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover">
                @else
                    <span class="text-gray-500 text-xs">No Image</span>
                @endif
            </div>
            
            <div class="grow">
                <h2 class="text-lg font-semibold text-gray-800">{{ $item->product->name }}</h2>
                <p class="text-sm text-gray-500">Category: {{ $item->product->category->name ?? 'Uncategorized' }}</p> 
            </div>

            <div class="text-right flex items-center space-x-4">
                <p class="text-xl font-bold text-red-600">£{{ number_format($item->product->price, 2) }}</p> 
                
                <button 
                    type="button"
                    data-product-id="{{ $item->product_id }}"
                    class="add-to-cart-btn bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-600 transition duration-300">
                    Add to Cart
                </button>

                <form action="{{ route('wishlist.remove') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition duration-300" onclick="return confirm('Remove from wishlist?')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500 text-lg mb-6">Your wishlist is empty</p>
        <a href="{{ route('home') }}" class="bg-indigo-500 text-white px-6 py-2 rounded-lg hover:bg-indigo-600 transition duration-300">
            Continue Shopping
        </a>
    </div>
    @endif
</div>

<script>

// Handle Add to Cart button clicks on the wishlist page
document.addEventListener('DOMContentLoaded', function() {
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    // On the wishlist page, we assume quantity is always 1 for simplicity
    addToCartButtons.forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault(); // Prevent default button behavior
            // Get product ID from data attribute
            const productId = this.getAttribute('data-product-id');
            // On wishlist page, quantity is always 1 by default
            const quantity = 1; 
            
            try {
                // Send AJAX request to add product to cart
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    }, 
                    // Send the product ID and quantity in the request body
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });
                // Parse the JSON response from the server
                const data = await response.json();
                // If the response is successful, update the cart badge and show a notification
                if (response.ok) {
                    // Update cart badge if function exists in your layout
                    if (typeof updateCartBadge === "function") {
                        updateCartBadge(data.cartCount);
                    }

                    // Show a simple success notification
                    const message = document.createElement('div');
                    message.textContent = 'Added to cart successfully!';
                    message.className = 'fixed top-4 right-4 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                    document.body.appendChild(message);
                    
                    // Remove message after 2 seconds
                    setTimeout(() => message.remove(), 2000);
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});
</script>

@endsection