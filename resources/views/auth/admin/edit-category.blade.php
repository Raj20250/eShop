@extends('layouts.admin.admin-main')

@section('title', 'Edit Category - E-Shop')

@section('content')
<div class="container mx-auto p-6 max-w-3xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Category: {{ $category->name }} (ID: {{ $category->id }})</h1>

    <div class="bg-white shadow-xl rounded-lg p-8">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <input type="hidden" name="category_id" value="{{ $category->id }}">

            <div>
                <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="category_name" name="category_name" value="{{ old('category_name', $category->name) }}" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="category_slug" class="block text-sm font-medium text-gray-700">Category Slug</label>
                <input type="text" id="category_slug" name="category_slug" value="{{ old('category_slug', $category->slug) }}"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500">Note: This is used for friendly URLs (e.g., /categories/{{ $category->slug }}).</p>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Category Status</label>
                <select id="status" name="status"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="active" {{ $category->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $category->status === 'inactive' ? 'selected' : '' }}>Inactive/Hidden</option>
                </select>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
