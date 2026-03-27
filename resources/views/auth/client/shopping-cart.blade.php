@extends('layouts.client.client-main')

@section('title', 'Products List - E-Shop')

@section('content')

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8 border-b pb-4">Your Shopping Cart</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <div class="lg:w-3/4 space-y-4">
            
            <div class="flex items-center bg-white p-4 rounded-lg shadow-md">
                <div class="w-20 h-20 bg-gray-200 mr-4 flex items-center justify-center shrink-0">
                    <span class="text-gray-500 text-xs">Prod Image 1</span>
                </div>
                
                <div class="grow">
                    <h2 class="text-lg font-semibold text-gray-800">High-Performance Laptop</h2>
                    <p class="text-sm text-gray-500">Price per item: £999.99 (price_at_that_time)</p> 
                    
                    <div class="flex items-center mt-2">
                        <span class="text-sm text-gray-600 mr-2">Quantity:</span>
                        <input type="number" value="1" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm">
                    </div>
                </div>

                <div class="flex flex-col items-end space-y-2">
                    <p class="text-xl font-bold text-indigo-600">£999.99</p> 
                    <button class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                </div>
            </div>

            <div class="flex items-center bg-white p-4 rounded-lg shadow-md">
                <div class="w-20 h-20 bg-gray-200 mr-4 flex items-center justify-center shrink-0">
                    <span class="text-gray-500 text-xs">Prod Image 2</span>
                </div>
                
                <div class="grow">
                    <h2 class="text-lg font-semibold text-gray-800">Cotton T-Shirt</h2>
                    <p class="text-sm text-gray-500">Price per item: £19.50 (price_at_that_time)</p> 
                    
                    <div class="flex items-center mt-2">
                        <span class="text-sm text-gray-600 mr-2">Quantity:</span>
                        <input type="number" value="2" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded-md text-center text-sm">
                    </div>
                </div>

                <div class="flex flex-col items-end space-y-2">
                    <p class="text-xl font-bold text-indigo-600">£39.00</p>
                    <button class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                </div>
            </div>

        </div>

        <div class="lg:w-1/4 bg-gray-100 p-6 rounded-lg shadow-inner sticky top-6 h-fit">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Cart Summary</h2>
            
            <div class="flex justify-between mb-2">
                <span class="text-gray-600">Subtotal (3 Items)</span>
                <span class="font-medium text-gray-800">£1038.99</span> 
            </div>
            <div class="flex justify-between mb-4">
                <span class="text-gray-600">Shipping Estimate</span>
                <span class="font-medium text-gray-800">£10.00</span> 
            </div>
            
            <div class="border-t pt-4 flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">Order Total (total_amount)</span>
                <span class="text-2xl font-extrabold text-indigo-600">£1048.99</span>
            </div>

            <a href="checkout.html" class="mt-6 w-full flex justify-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-lg transition duration-300">
                Proceed to Checkout
            </a>
        </div>
    </div>
</div>

@endsection