<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Display listing of products with category
    public function index(Request $request)
    {     // Start query with eager loading of category to avoid N+1 problem
        $query = Product::with('category');
        // Apply search filter if search term is provided
        if ($request->has('search')) {
            //
            $search = $request->search;
            // Use LIKE operator for partial matching in product name
            $query->where('name', 'LIKE', "%{$search}%");
        }     // Paginate results to show 10 products per page
        $products = $query->latest()->paginate(10);
        return view('auth.admin.show-product', compact('products'));
    }


//Show the form for creating a new product
public function create()
{
    // Fetching categories to show in dropdown
    $categories = \App\Models\Category::all();
    return view('auth.admin.add-products', compact('categories'));
}

//  Store a newly created product in database
//  Show form to create a new product
    
    // Store newly created product in the database
    public function store(Request $request)
    {
        // Validate all required fields including image
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive,out_of_stock,draft'
        ]);

        // Create new product instance and fill in the details
        $product = new Product();
        $product->name = $request->name;

        // Create a unique slug to fix the "Field slug doesn't have a default value" error
        $product->slug = Str::slug($request->name) . '-' . time();

        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->status = $request->status;

        // Handle file upload to public/uploads/products directory
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $filename);
            $product->image = 'uploads/products/' . $filename;
        }

        $product->save();

        // Redirect to product list with a success message
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    
    // Show the edit form with existing product data
public function edit(string $id)
{
    // Fetch product and categories to show in dropdown
    $product = Product::findOrFail($id);
    // Note: Assuming you have a Category model
    $categories = \App\Models\Category::all(); 
    
    return view('auth.admin.edit-product', compact('product', 'categories'));
}

    


    

// Full update method to handle product info and multiple images
public function update(Request $request, string $id)
{
    $product = Product::findOrFail($id);

    // Quick status update logic
    if ($request->has('status') && !$request->has('name')) {
        $request->validate(['status' => 'required|in:active,inactive,out_of_stock']);
        $product->status = $request->status;
        $product->save();
        return back()->with('success', 'Status updated successfully!');
    }

    // Validate all fields for full update
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required',
        'additional_images.*' => 'image|mimes:jpeg,png,jpg|max:2048' // اضافی تصاویر کی توثیق
    ]);

    // Updating basic product information
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->stock = $request->stock;
    $product->category_id = $request->category_id;
    $product->status = $request->status;

    
    // Main image upload logic
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_main.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/products'), $filename);
        $product->image = 'uploads/products/' . $filename;
    }

    $product->save();

    // Logic to store additional images in the product_images table
    if ($request->hasFile('additional_images')) {
        foreach ($request->file('additional_images') as $imageFile) {
            $extraName = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('uploads/products'), $extraName);
            
            
            // Save to product_images table using relationship
            $product->product_images()->create([
                'image_path' => 'uploads/products/' . $extraName
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}

    //  Show single product details
    public function show(string $id)
    {
        // Eager-load product images so the view can show multiple thumbnails without extra queries
        $product = Product::with(['category', 'product_images'])->findOrFail($id);
        return view('auth.admin.show-single-product', compact('product'));
    }

    // Handle product deletion with safety check
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Check if product is linked to any orders before deleting
        if ($product->orderItems()->exists()) {
            return back()->with('error', 'Cannot delete! This product is linked to existing orders. Try making it Inactive instead.');
        }
//        // Delete associated images from storage
        $product->delete();
        return back()->with('success', 'Product deleted successfully!');
    }
}