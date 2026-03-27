@extends('layouts.client.client-main')

@section('title', 'Products List - E-Shop')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Our Products</h1>
    
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
        
        <form action="{{ route('home') }}" method="GET" class="flex items-center space-x-2 md:w-1/3">
            <input type="search" name="search_term" placeholder="Search products..." 
                   value="{{ request('search_term') }}"
                   class="grow px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            <button type="submit" class="bg-indigo-600 text-white p-3 rounded-lg hover:bg-indigo-700 transition duration-150">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
        
        <form action="{{ route('home') }}" method="GET" class="md:w-1/3">
            <label for="sort_by" class="block text-sm font-medium text-gray-700 sr-only">Sort By</label>
            <select id="sort_by" name="sort_by" onchange="this.form.submit()" 
                    class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white">
                <option value="latest" {{ request('sort_by') == 'latest' ? 'selected' : '' }}>Sort By: Latest (Newest)</option>
                <option value="price_asc" {{ request('sort_by') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort_by') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="name_asc" {{ request('sort_by') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
            </select>
            @if(request('search_term'))
                <input type="hidden" name="search_term" value="{{ request('search_term') }}">
            @endif
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            </form>
    </div>

    <div class="mb-8 flex flex-wrap gap-3">
        <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium text-white {{ !request('category') ? 'bg-indigo-600' : 'bg-gray-200 text-gray-700' }} rounded-full hover:bg-indigo-700 transition duration-150">
            All Products
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->slug]) }}" class="px-4 py-2 text-sm font-medium {{ request('category') == $category->slug ? 'text-white bg-indigo-600' : 'text-gray-700 bg-gray-200 hover:bg-gray-300' }} rounded-full transition duration-150">
                {{ $category->name }} ({{ $category->slug }})
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        
        @forelse ($products as $product)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition duration-300 ease-in-out">
            <a href="{{ route('product.detail', ['product' => $product->id]) }}" class="block"> 
                <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                    @if($product->image)

                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover"> 

                    @else
                        <span class="text-gray-500">Image: {{ $product->name }}</span>
                    @endif
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-semibold text-gray-800 truncate hover:text-indigo-600 transition duration-150">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
                    <p class="text-lg font-bold text-red-600 mb-3">£{{ number_format($product->price, 2) }}</p>
                </div>
            </a>
            <div class="flex justify-between items-center p-5 pt-0">
                <span class="text-xs font-medium px-2 py-0.5 rounded-full {{ $product->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }} ({{ $product->stock }})
                </span>

                @if($product->stock > 0)
                        <span class="text-sm text-gray-600 mr-2">Qty:</span>
                        <input type="number" value="1" min="1" max="{{ $product->stock }}" class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm">
                @else
                        <span class="text-sm text-red-600 font-semibold">Out of Stock</span>
                @endif

                <div class="flex gap-2">
                    <button 
                        type="button"
                        {{ $product->stock > 0 ? '' : 'disabled' }} 
                        data-product-id="{{ $product->id }}"
                        class="add-to-cart-btn bg-indigo-500 text-white p-2 rounded-full hover:bg-indigo-600 transition duration-150 {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        title="Add to Cart">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </button>

                    @auth
                    <button 
                        type="button"
                        data-product-id="{{ $product->id }}"
                        class="add-to-wishlist-btn bg-red-100 text-red-600 p-2 rounded-full hover:bg-red-200 transition duration-150"
                        title="Add to Wishlist">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500 text-lg">No products found. Try adjusting your search or filters.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="mt-8 flex justify-center">
        {{ $products->links() }}
    </div>
    @endif
</div>

<!-- Cart JavaScript -->
<!-- Cart & Wishlist JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Select all "Add to Cart" buttons
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    // Select all "Add to Wishlist" buttons
    const addToWishlistButtons = document.querySelectorAll('.add-to-wishlist-btn');


    /*
    |--------------------------------------------------------------------------
    | ADD TO CART FUNCTIONALITY
    |--------------------------------------------------------------------------
    | This sends an AJAX request to the server without reloading the page.
    | It collects the product ID and quantity, then sends them to the
    | Laravel route using the Fetch API.
    */

    addToCartButtons.forEach(button => {
        button.addEventListener('click', async function (e) {

            e.preventDefault();

            // Get product ID from data attribute
            const productId = this.getAttribute('data-product-id');

            // Find the quantity input near the button
            const quantityInput = this.closest('.flex').querySelector('input[type="number"]');

            // If quantity input exists use its value, otherwise default to 1
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            try {

                // Send POST request to Laravel cart route
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',

                        // CSRF token required by Laravel for POST requests
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },

                    // Send product ID and quantity to backend
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                // Convert response into JSON
                const data = await response.json();

                if (response.ok) {

                    // Update cart badge count in navbar
                    updateCartBadge(data.cartCount);

                    // Reset quantity input to 1 after adding
                    if (quantityInput) {
                        quantityInput.value = 1;
                    }
                }

            } catch (error) {

                // Log error for debugging
                console.error('Cart Error:', error);

            }

        });
    });



    /*
    |--------------------------------------------------------------------------
    | ADD TO WISHLIST FUNCTIONALITY
    |--------------------------------------------------------------------------
    | Sends product ID to backend and updates UI if successful.
    */

    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', async function (e) {

            e.preventDefault();

            // Get product ID from data attribute
            const productId = this.getAttribute('data-product-id');

            try {

                // Send POST request to Laravel wishlist route
                const response = await fetch('{{ route("wishlist.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',

                        // CSRF token for Laravel protection
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },

                    // Send product ID to backend
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                // Convert server response to JSON
                const data = await response.json();

                if (response.ok) {

                    // Change button style to indicate item added
                    this.classList.add('bg-red-200');
                    this.classList.remove('bg-red-100');


                    /*
                    ------------------------------------------------------------
                    | SHOW SUCCESS NOTIFICATION
                    ------------------------------------------------------------
                    | A temporary message appears on the screen and disappears
                    | automatically after a short delay.
                    */

                    const message = document.createElement('div');

                    message.textContent = 'Added to wishlist';

                    message.className =
                        'fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-2xl z-50 transform transition-all duration-500 ease-in-out';

                    document.body.appendChild(message);

                    // Small slide effect
                    message.style.marginTop = '10px';

                    // Remove notification after 2 seconds
                    setTimeout(() => {
                        message.style.opacity = '0';

                        setTimeout(() => message.remove(), 500);

                    }, 2000);
                }

            } catch (error) {

                // Log error for debugging
                console.error('Wishlist Error:', error);

            }

        });
    });

});
</script>

@endsection
