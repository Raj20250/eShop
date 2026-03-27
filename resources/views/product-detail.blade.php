@extends('layouts.client.client-main')

@section('title', $product->name . ' - E-Shop')

@section('content')
<div class="container mx-auto p-6">
    
    {{-- Navigation link to go back to products --}}

    <nav class="mb-6">
        <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 transition">← Back to Products</a>
    </nav>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            
            {{-- Image Section Start --}}
            <div>
                {{-- Main Product Image Display Area --}}
                <div class="h-96 w-full bg-gray-100 rounded-xl overflow-hidden mb-4 border border-gray-200 shadow-inner flex items-center justify-center">
                    {{-- Note: asset() is used directly because path starts with 'uploads/' in DB --}}
                    <img id="mainFeaturedImage" src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="max-h-full object-contain transform hover:scale-110 transition duration-500">
                </div>

                {{-- Image Gallery Thumbnails --}}
                <div class="grid grid-cols-4 gap-4">
                    {{-- 1. Main Image as first thumbnail --}}
                    <div class="h-24 bg-white rounded-lg border border-gray-200 overflow-hidden cursor-pointer hover:ring-2 hover:ring-indigo-500 transition" 
                         onclick="changeDisplayImage('{{ asset($product->image) }}')">
                        <img src="{{ asset($product->image) }}" class="w-full h-full object-cover">
                    </div>

                    {{-- 2. Loop through additional images from product_images table --}}
                    @if($product->product_images && $product->product_images->count() > 0)
                        @foreach($product->product_images as $extraImage)
                            <div class="h-24 bg-white rounded-lg border border-gray-200 overflow-hidden cursor-pointer hover:ring-2 hover:ring-indigo-500 transition" 
                                 onclick="changeDisplayImage('{{ asset($extraImage->image_path) }}')">
                                <img src="{{ asset($extraImage->image_path) }}" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{-- Image Section End --}}

            {{-- Product Details Section --}}
            <div class="flex flex-col justify-center">
                
                {{-- Category Badge --}}
                <span class="inline-block px-3 py-1 text-xs font-semibold tracking-wide text-indigo-600 uppercase bg-indigo-100 rounded-full w-max mb-4">
                    {{ $product->category->name }}
                </span>

                <h1 class="text-4xl font-extrabold text-gray-900 mb-4">{{ $product->name }}</h1>

                {{-- Price Tag --}}
                <div class="text-3xl font-bold text-indigo-600 mb-6">
                    ${{ number_format($product->price, 2) }}
                </div>

                {{-- Stock Status --}}
                <div class="mb-6 flex items-center">
                    <span class="text-gray-700 font-medium mr-2 text-lg">Availability:</span>
                    @if($product->stock > 0)
                        <span class="text-green-600 font-bold bg-green-50 px-3 py-1 rounded-lg border border-green-200">
                            {{ $product->stock }} in Stock
                        </span>
                    @else
                        <span class="text-red-600 font-bold bg-red-50 px-3 py-1 rounded-lg border border-red-200">
                            Out of Stock
                        </span>
                    @endif
                </div>

                {{-- Description Section --}}
                <div class="mb-8 border-t border-gray-100 pt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Description</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $product->description ?? 'No description provided for this product.' }}
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-4">
                 
{{-- Quantity and Add to Cart Section --}}
<div class="flex items-center gap-4 mt-8">
    {{-- Quantity Input --}}
    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
        <span class="px-3 py-2 bg-gray-50 text-gray-600 border-r text-sm font-semibold">Qty:</span>
        <input type="number" id="detail_quantity" value="1" min="1" max="{{ $product->stock }}" 
               class="w-16 px-2 py-2 text-center focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    {{-- Add to Cart Button (Identical logic to List Page) --}}
    <button 
        type="button"
        id="add_to_cart_detail_btn"
        data-product-id="{{ $product->id }}"
        {{ $product->stock > 0 ? '' : 'disabled' }} 
        class="flex-1 bg-indigo-600 text-white font-bold py-4 px-8 rounded-xl hover:bg-indigo-700 transition duration-300 shadow-lg shadow-indigo-100 {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}">
        Add to Cart
    </button>
</div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript Function to change the large image when a thumbnail is clicked --}}
<script>
    function changeDisplayImage(imageSource) {
        // Find the main image element by ID and update its source
        document.getElementById('mainFeaturedImage').src = imageSource;
    }
</script>


<<script>
// JavaScript to handle Add to Cart functionality on the product detail page, similar to the product list page
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('add_to_cart_detail_btn');
    
    //  Check if the button exists before adding event listener
    if(btn) {
        btn.addEventListener('click', async function() {
            const productId = this.getAttribute('data-product-id');
            const qtyInput = document.getElementById('detail_quantity');
            const quantity = qtyInput ? parseInt(qtyInput.value) : 1;
            
            try {
                // Fetch call to save item in cart without page refresh
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
                    //  Update the cart badge (if the function exists)
                    if (typeof updateCartBadge === "function") {
                        updateCartBadge(data.cartCount);
                    }

                    // Create and show a professional notification instead of alert
                    showNotification('Product added to cart successfully!');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    }

    //  Function to show message just like your product list
    function showNotification(text) {
        const msg = document.createElement('div');
        msg.textContent = text;
        msg.className = 'fixed top-20 right-4 bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-2xl z-50 transform transition-all duration-500';
        document.body.appendChild(msg);

// Remove the notification after 2.5 seconds
        setTimeout(() => {
            msg.style.opacity = '0';
            setTimeout(() => msg.remove(), 500);
        }, 2500);
    }
});
</script>
@endsection