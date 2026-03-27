@extends('layouts.client.client-main')

@section('title', 'About Us - E-Shop')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
    <h1 class="text-4xl font-bold text-gray-800 mb-8 border-b pb-4">About Us</h1>

    <div class="bg-white shadow-lg rounded-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to Our Store</h2>
        
        <div class="text-gray-700 leading-relaxed mb-6">
            We are dedicated to providing the best products and services to our customers. Our journey started with a simple idea of making online shopping easier and more accessible for everyone.
            </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 mb-6">
            <h3 class="text-xl font-semibold text-blue-900 mb-2">Our Mission</h3>
            <p class="text-gray-700">To provide high-quality products that bring value to our customers' lives.</p>
        </div>

        <div class="bg-green-50 border-l-4 border-green-500 p-6">
            <h3 class="text-xl font-semibold text-green-900 mb-2">Our Vision</h3>
            <p class="text-gray-700">To be the most trusted online marketplace for shoppers around the world.</p>
        </div>
    </div>
</div>
@endsection