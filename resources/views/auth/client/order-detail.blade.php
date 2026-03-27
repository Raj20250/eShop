@extends('layouts.client.client-main')

@section('title', 'Order Detail - #' . $order->order_number)

@section('content')

<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto">
       

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Order Summary</h2>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Order Number</p>
                        <p class="font-bold text-gray-800">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Date</p>
                        <p class="font-bold text-gray-800">{{ $order->created_at->format('d M, Y h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <span class="px-2 py-1 rounded text-xs font-bold 
                            @if($order->status == 'delivered') bg-green-100 text-green-700 
                            @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700 
                            @else bg-blue-100 text-blue-700 @endif">
                            {{ strtoupper($order->status) }}
                        </span>
                    </div>
                 
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-indigo-500">
                <h2 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2">Shipping To</h2>
                <div class="text-sm space-y-1">
                    <p class="font-bold text-gray-900">{{ $order->customer_name }}</p>
                    <p class="text-gray-600">{{ $order->customer_email }}</p>
                    <p class="text-gray-600">{{ $order->customer_phone }}</p>
                    <p class="text-gray-700 mt-2 italic leading-relaxed">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->products as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-12 w-12 shrink-0">
                                    <img class="h-12 w-12 rounded object-cover shadow-sm" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $product->category->name ?? 'No Category' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-700">
                            {{ $product->pivot->quantity }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm text-gray-700">
                            ${{ number_format($product->pivot->price, 2) }}
                        </td>
                        <td class="px-6 py-4 text-right text-sm font-bold text-indigo-600">
                            ${{ number_format($product->pivot->total, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-8 ml-auto max-w-xs">
            <div class="space-y-3">
                <div class="flex justify-between text-gray-600">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-600">
                    <span>Shipping:</span>
                    <span class="text-green-600 font-medium">Free</span>
                </div>
                <div class="border-t pt-3 flex justify-between items-center">
                    <span class="text-lg font-bold text-gray-800">Grand Total:</span>
                    <span class="text-2xl font-black text-indigo-700">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ route('home') }}" class="flex-1 bg-gray-800 hover:bg-black text-white font-bold py-3 px-6 rounded-lg text-center transition duration-300">
                Continue Shopping
            </a>
            <button onclick="window.print()" class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 px-6 rounded-lg text-center transition duration-300 shadow-sm">
                Print Invoice
            </button>
        </div>
    </div>
</div>

@endsection