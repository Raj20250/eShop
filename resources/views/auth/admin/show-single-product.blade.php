@extends('layouts.admin.admin-main')

@section('title', 'Product Details - ' . $product->name)

@section('content')

<div class="container mx-auto p-6 max-w-5xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Product Details</h1>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
            &larr; Back to List 
        </a>
    </div>

    <div class="bg-white shadow-xl rounded-lg overflow-hidden border">
        <div class="md:flex">
            <div class="md:w-1/3 bg-gray-50 flex flex-col items-center justify-center p-6">
                <div class="w-full h-72 bg-white rounded-lg overflow-hidden border border-gray-200 shadow-inner mb-4 flex items-center justify-center">
                    <img id="mainFeaturedImage" src="{{ asset($product->image ?? 'https://via.placeholder.com/300') }}" alt="{{ $product->name }}" class="max-h-full object-contain">
                </div>

                <div class="grid grid-cols-3 gap-3 w-full">
                    <button type="button" class="h-20 rounded-lg overflow-hidden border border-gray-200 hover:ring-2 hover:ring-indigo-500 transition" onclick="changeDisplayImage('{{ asset($product->image ?? 'https://via.placeholder.com/300') }}')">
                        <img src="{{ asset($product->image ?? 'https://via.placeholder.com/300') }}" class="w-full h-full object-cover">
                    </button>

                    @foreach($product->product_images->take(2) as $extraImage)
                        <button type="button" class="h-20 rounded-lg overflow-hidden border border-gray-200 hover:ring-2 hover:ring-indigo-500 transition" onclick="changeDisplayImage('{{ asset($extraImage->image_path) }}')">
                            <img src="{{ asset($extraImage->image_path) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="md:w-2/3 p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-sm font-semibold text-indigo-600 uppercase">{{ $product->category->name ?? 'Uncategorized' }}</span>
                        <h2 class="text-4xl font-extrabold text-gray-900 mt-2">{{ $product->name }}</h2>
                    </div>
                    <span class="px-3 py-1 rounded-full text-sm font-bold {{ $product->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <div class="mt-6 border-t border-gray-100 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Full Description</h3>
                    <p class="mt-2 text-gray-600 leading-relaxed text-justify">
                        {{ $product->description }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-6 mt-8">
                    <div class="bg-indigo-50 p-4 rounded-lg text-center border border-indigo-100">
                        <p class="text-sm text-indigo-600 font-medium uppercase">Unit Price</p>
                        <p class="text-3xl font-bold text-indigo-900">£{{ number_format($product->price, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center border border-gray-200">
                        <p class="text-sm text-gray-600 font-medium uppercase">Total Stock</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $product->stock ?? 0 }} <span class="text-sm font-normal">Units</span></p>
                    </div>
                </div>

                <div class="mt-10 flex space-x-4">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="flex-1 bg-yellow-500 text-white text-center py-3 rounded-md font-bold hover:bg-yellow-600 transition">
                        Edit This Product
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeDisplayImage(imageSource) {
        const mainImage = document.getElementById('mainFeaturedImage');
        if (mainImage) {
            mainImage.src = imageSource;
        }
    }
</script>

@endsection