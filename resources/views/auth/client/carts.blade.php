@extends('layouts.client.client-main')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">
        Your Shopping Cart
    </h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-3/4">
            <div id="cart-items-container">
                <div id="empty-cart-message" class="bg-white p-8 rounded-lg shadow text-center hidden">
                    <p class="text-gray-500 text-lg">Your cart is empty</p>
                    <a href="{{ route('home') }}"
                       class="mt-4 inline-block bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition">
                        Continue Shopping
                    </a>
                </div>

                <div id="cart-items-list" class="space-y-4"></div>
            </div>
        </div>

        <div class="lg:w-1/4 bg-gray-100 p-6 rounded-lg shadow-inner sticky top-6 h-fit">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">
                Cart Summary
            </h2>

            <div class="flex justify-between mb-2">
                <span class="text-gray-600">
                    Subtotal (<span id="item-count">0</span> Items)
                </span>
                <span class="font-medium text-gray-800">
                    £<span id="subtotal">0.00</span>
                </span>
            </div>

            <div class="border-t pt-4 flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">
                    Order Total
                </span>
                <span class="text-2xl font-extrabold text-indigo-600">
                    £<span id="cart-total">0.00</span>
                </span>
            </div>

            <button id="clear-all-btn"
                class="mt-4 w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-lg">
                Clear Cart
            </button>

            <a href="{{ route('checkout') }}" class="mt-2 w-full flex justify-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition duration-300">
                Proceed to Checkout
            </a>
        </div>
    </div>
</div>

<script>

// Wait for the DOM to load before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {
// Get references to key elements
    const cartItemsList = document.getElementById('cart-items-list');
    const emptyMessage = document.getElementById('empty-cart-message');
    const clearAllBtn = document.getElementById('clear-all-btn');
// Initial
    loadCart();
// Function to load cart items from the server and render them
    async function loadCart() {
        try { // Fetch cart data from the server
            const response = await fetch('{{ route("cart.get") }}');
            const data = await response.json();
// Clear the current cart items list before rendering new data
            cartItemsList.innerHTML = '';
// If the cart is empty, show the empty message and reset summary and badge
            if (Object.keys(data.cart).length === 0) {
                emptyMessage.classList.remove('hidden');
                updateSummary(0, 0);
                updateBadge(0);
                return;
            }
// If there are items in the cart, hide the empty message and render each item
            emptyMessage.classList.add('hidden');
// Loop through each cart item and create HTML elements to display them
            let total = 0;
            let itemCount = 0;
// Loop through each item in the cart data and create HTML for it
            for (const [productId, item] of Object.entries(data.cart)) {
// Calculate total price and item count for the summary
                total += item.total;
                itemCount += item.quantity;
// Append the cart item HTML to the cart items list
                cartItemsList.innerHTML += `
                    <div class="flex items-center bg-white p-4 rounded-lg shadow-md cart-item"
                         data-product-id="${productId}">

                        <div class="grow">
                            <h2 class="text-lg font-semibold text-gray-800">
                                ${item.name}
                            </h2>

                            <p class="text-sm text-gray-500">
                                Price: £${item.price.toFixed(2)}
                            </p>

                            <input type="number"
                                   min="1"
                                   value="${item.quantity}"
                                   class="quantity-input w-16 px-2 py-1 border rounded-md text-center mt-2">
                        </div>

                        <div class="flex flex-col items-end">
                            <p class="text-xl font-bold text-indigo-600">
                                £${item.total.toFixed(2)}
                            </p>

                            <button class="remove-item-btn text-red-500 text-sm mt-2">
                                Remove
                            </button>
                        </div>
                    </div>
                `;
            }
// After rendering all items, update the summary and badge counts, and attach event listeners to the new elements
            updateSummary(itemCount, total);
            updateBadge(data.cartCount);
            attachEvents();
// Catch any errors that occur during the fetch or rendering process
        } catch (error) {
            console.error('Cart load error:', error);
        }
    }
// Function to update the cart summary section with the current item count and total price
    function updateSummary(count, total) {
        document.getElementById('item-count').textContent = count;
        document.getElementById('subtotal').textContent = total.toFixed(2);
        document.getElementById('cart-total').textContent = total.toFixed(2);
    }

    function attachEvents() {
// Attach event listeners to quantity inputs and remove buttons for each cart item
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.onchange = async function () {
                const pid = this.closest('.cart-item')
                                .getAttribute('data-product-id');
// Send an AJAX request to update the cart with the new quantity for the specific product
                await fetch('{{ route("cart.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: pid,
                        quantity: this.value
                    })
                });

                loadCart();
            };
        });
// Attach event listeners to remove buttons for each cart item
        document.querySelectorAll('.remove-item-btn').forEach(btn => {
            btn.onclick = async function () {
                const pid = this.closest('.cart-item')
                                .getAttribute('data-product-id');
// Send an AJAX request to remove the specific product from the cart
                await fetch('{{ route("cart.remove") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: pid
                    })
                });

                loadCart();
            };
        });
    }
// Attach event listener to the "Clear Cart" button to clear all items from the cart
    if (clearAllBtn) {
        clearAllBtn.onclick = async function () {
            await fetch('{{ route("cart.clear") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            loadCart();
        };
    }
// Function to update the cart badge count in the header
    function updateBadge(count) {
        const badge = document.querySelector('.cart-badge-count');
        if (badge) badge.textContent = count;
    }

});
</script>

@endsection
