@extends('layouts.admin.admin-main')

@section('title', 'Products List - E-Shop')

@section('content')

<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
          
          <a href="{{ route('admin.users.index') }}" class="block bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-lg transition duration-150">

            <div class="text-sm font-medium text-gray-500">Total Users</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">1,250</div>
            <p class="text-xs text-indigo-500 mt-2">View all users</p>
        </a>

            
        <a href="{{ route('admin.categories.index') }}" class="block bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-lg transition duration-150">

            <div class="text-sm font-medium text-gray-500">Total Categories</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalCategories) }}</div>
            <p class="text-xs text-green-500 mt-2">View all Categories detail</p>
        </a>

          
            <a href="{{ route('admin.products.index') }}" class="block bg-white p-5 rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-lg transition duration-150">

            <div class="text-sm font-medium text-gray-500">Total Products</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">320</div>
            <p class="text-xs text-yellow-500 mt-2">Manage products</p>
        </a>

        <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-red-500">
            <div class="text-sm font-medium text-gray-500">Total Revenues</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">£{{ number_format($totalRevenue, 2) }}</div>
            <p class="text-xs text-red-500 mt-2">Financial overview </p>
        </div>
    </div>
    
    </div>
     
{{-- End of container --}}



    {{-- pending orders --}}

<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Pending Orders (orders table)</h1>

    <div class="mb-6 flex justify-between items-center bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500 shadow-md">
        <p class="text-lg font-medium text-gray-700">Total Pending Orders: <span class="font-bold text-yellow-700">{{ $pendingCount ?? 0 }}</span></p>
        <div class="text-sm text-gray-600">
            <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">View All Orders ({{ $totalOrders ?? 0 }})</a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Placed</th>
                        
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status (Update)</th>
                        
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingOrders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $order->order_number ?? '#'.$order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $order->customer_name ?? ($order->user->name ?? '—') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">£{{ number_format($order->total_amount, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($order->created_at)->format('Y-m-d') }}</td>
                        
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.dashboard.update', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="order_status" onchange="this.form.submit()" 
                                        class="block w-full pl-3 pr-10 py-1 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-gray-50">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ url('admin/dashboard/'.$order->id) }}" class="text-blue-600 hover:text-blue-900" title="View">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                                

                                <form action="{{ url('admin/dashboard/'.$order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm text-gray-500">No pending orders.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection