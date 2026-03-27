@extends('layouts.client.client-main')

@section('title', 'Checkout - E-Shop')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Checkout</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        
        <div class="lg:w-2/3 bg-white p-6 rounded-lg shadow-md">
            <form action="{{ route('checkout.place-order') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">1. Customer Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="customer_name" name="customer_name" value="{{ $user->name ?? '' }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="customer_email" name="customer_email" value="{{ $user->email ?? '' }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" id="customer_phone" name="customer_phone" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="+92...">
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">2. Shipping Address</h2>
                    
                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">Shipping Address</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Enter your complete shipping address"></textarea>
                    </div>
                </div>

            

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">4. Order Items</h2>
                    
                    <div class="space-y-2">
                        @foreach($items as $productId => $item)
                        <div class="flex justify-between p-3 bg-gray-50 rounded">
                            <span>{{ $item['product']->name }} (x{{ $item['quantity'] }})</span>
                            <span class="font-medium">£{{ number_format($item['total'], 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition duration-300">
                    Place Order & Pay
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:w-1/3 bg-gray-100 p-6 rounded-lg shadow-inner sticky top-6 h-fit">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Order Summary</h2>
            
            <div class="space-y-3 mb-4">
                @foreach($items as $productId => $item)
                <div class="flex justify-between text-sm">
                    <span>{{ $item['product']->name }} x{{ $item['quantity'] }}</span>
                    <span>£{{ number_format($item['total'], 2) }}</span>
                </div>
                @endforeach
            </div>

            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">£{{ number_format($total, 2) }}</span>
                </div>
            
                <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                    <span>Total</span>
                    <span class="text-indigo-600">£{{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection