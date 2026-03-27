@extends('layouts.admin.admin-main')

@section('title', 'Total Products - E-Shop')

@section('content')

<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Total Products</h1>
        <a href="{{ url('admin/products/create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-medium transition duration-150">
            + Add New Product
        </a>
    </div>
    display error message
    @if(session('error'))  
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>

    </div>
    @endif
    
    <nav class="text-sm text-gray-500" aria-label="Breadcrumb">
    <div class="mb-6 bg-white p-4 rounded-lg shadow-md">
        <form action="{{ url('admin/products') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative w-full md:w-1/2">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                       placeholder="Search products by name...">
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 text-sm font-medium">
                Search
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">#{{ $product->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset($product->image ?? 'https://via.placeholder.com/50') }}" alt="Product Image">
                                </div>

                                
                                <div class="ml-4 text-sm font-medium text-gray-900">{{ $product->name }}</div>
                            </div>
                        </td>
                        
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $product->category->name ?? 'General' }}
                        </td>

                        <td class="px-6 py-4 text-sm font-semibold text-gray-800">£{{ number_format($product->price, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $product->stock ?? 0 }} Units</td>
                        
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="this.form.submit()" 
                                        class="text-xs border-gray-300 rounded-md font-semibold cursor-pointer">
                                    <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </form>
                        </td>

                        <td class="px-6 py-4 text-center text-sm font-medium">
                            <div class="flex items-center justify-center space-x-3">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-6 py-10 text-center">No products found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection