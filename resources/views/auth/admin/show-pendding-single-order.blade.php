@extends('layouts.admin.admin-main')

@section('title', 'Order Details - E-Shop')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Order Details: {{ $order->order_number }}</h1>
        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold uppercase">
            Status: {{ $order->status }}
        </span>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg mb-6 border">
        <h2 class="font-bold text-gray-700 mb-2">Customer Information</h2>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
    </div>

    <h2 class="text-xl font-semibold mb-4 text-gray-800">Purchased Products (Order Items)</h2>

    @if($order->orderItems->isEmpty())
        <p class="text-gray-600 italic text-center py-4 bg-white rounded border">No products found for this order.</p>
    @else
        <div class="overflow-x-auto shadow-sm rounded-lg border">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-sm font-bold text-gray-600">Product Name</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-600">Unit Price</th>
                        <th class="py-3 px-4 border-b text-center text-sm font-bold text-gray-600">Quantity</th>
                        <th class="py-3 px-4 border-b text-right text-sm font-bold text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($order->orderItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4 text-sm text-gray-700">
                                {{ $item->product->name ?? 'Product Removed' }}
                            </td>
                            <td class="py-3 px-4 text-center text-sm text-gray-700">
                                £{{ number_format($item->price, 2) }}
                            </td>
                            <td class="py-3 px-4 text-center text-sm text-gray-700">
                                {{ $item->quantity }}
                            </td>
                            <td class="py-3 px-4 text-right text-sm font-semibold text-gray-800">
                                £{{ number_format($item->total, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 font-bold">
                    <tr>
                        <td colspan="3" class="py-3 px-4 text-right text-gray-700 uppercase">Grand Total:</td>
                        <td class="py-3 px-4 text-right text-indigo-700 text-lg">
                            £{{ number_format($order->total_amount, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif

    <div class="mt-8">
        <a href="{{ route('admin.dashboard.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
            &larr; Back to Dashboard
        </a>
    </div>
</div>
@endsection