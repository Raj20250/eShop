@extends('layouts.client.client-main')

@section('title', 'Order Success - E-Shop')

@section('content')

<div class="container mx-auto p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Success Message -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
            <div class="flex items-center justify-center mb-4">
                <div class="flex-0">
                    <svg class="h-12 w-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-bold text-green-800 text-center mb-2">Order Confirmed!</h1>
            <p class="text-green-700 text-center">Your payment has been processed successfully.</p>
        </div>

        <!-- Order Details -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Order Details</h2>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-semibold text-gray-800">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Order Date:</span>
                    <span class="font-semibold text-gray-800">{{ $order->created_at->format('d M, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status:</span>
                    <span class="font-semibold text-green-600">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Method:</span>
                    <span class="font-semibold text-gray-800">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Transaction ID:</span>
                    <span class="font-semibold text-gray-800">{{ $order->transaction_id ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Customer Information</h2>
            
            <div class="space-y-2 text-gray-700">
                <p><strong>Name:</strong> {{ $order->customer_name }}</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
                <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Order Items</h2>
            
            <div class="space-y-3">
                @foreach($order->orderitems as $item)
                <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                    <div>
                        <p class="font-semibold text-gray-800">{{ $item->product->name }}</p>
                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }} × £{{ number_format($item->price, 2) }}</p>
                    </div>
                    <span class="font-bold text-indigo-600">£{{ number_format($item->total, 2) }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-gray-100 rounded-lg p-6 mb-8">
            <div class="space-y-2 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal:</span>
                    <span class="text-gray-800">£{{ number_format($order->total_amount, 2) }}</span>
                </div>
             
            </div>
            <div class="border-t pt-4 flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">Total:</span>
                <span class="text-2xl font-bold text-indigo-600">£{{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="{{ route('order.history') }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg text-center transition duration-300">
                View My Orders
            </a>
            <a href="{{ route('home') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 rounded-lg text-center transition duration-300">
                Continue Shopping
            </a>
        </div>

    
    </div>
</div>

@endsection
