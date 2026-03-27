<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'E-Shop')</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    @include('layouts.client.client-partials.client-header')

    <main class="grow">
        @yield('content')
    </main>

    @include('layouts.client.client-partials.client-footer')

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update cart badge on page load
            updateCartBadgeOnLoad();
        });
// Function to fetch cart count and update the badge
        function updateCartBadgeOnLoad() {
            fetch('{{ route("cart.get") }}')
                .then(response => response.json())
                .then(data => {
                    updateCartBadge(data.cartCount);
                })
                .catch(error => console.log('Cart not available'));
        }
// Function to update the cart badge count
        function updateCartBadge(count) {
            const badge = document.querySelector('.cart-badge-count');
            if (badge) {
                badge.textContent = count;
            }
        }

        // Make updateCartBadge globally available
        window.updateCartBadge = updateCartBadge;
    </script>

    @stack('scripts')
</body>
</html>