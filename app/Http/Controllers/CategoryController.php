<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Display all categories
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('auth.admin.show-category', compact('categories'));
    }

    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|max:255|unique:categories,slug',
            'status' => 'required|in:active,inactive',
        ]);

        Category::create([
            'name' => $request->category_name,
            'slug' => Str::slug($request->category_slug ?: $request->category_name),
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Category added successfully');
    }

    // Edit category page
    public function edit(Category $category)
    {
        return view('auth.admin.edit-category', compact('category'));
    }

    // Update category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'status' => 'required|in:active,inactive',
        ]);

        $category->update([
            'name' => $request->category_name,
            'slug' => Str::slug($request->category_slug ?: $request->category_name),
            'status' => $request->status,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
    }

    // Delete category
    public function destroy(Category $category)
    {
        // Prevent delete if category has products
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete this category because it has products.');
        }

        $category->delete(); // soft delete
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
