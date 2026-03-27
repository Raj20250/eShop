<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::where('status', 'active');

        // Search functionality
        if ($request->filled('search_term')) {
            $search = $request->search_term;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'latest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination - 12 items per page
        $products = $query->paginate(12);

        // Get all categories for filter display
        $categories = Category::all();

        return view('welcome', compact('products', 'categories'));
    }






   // Function to show product detail page
public function productDetail($id)
{
    // Fetch product with its category and multiple images using Eager Loading
    $product = Product::with(['category', 'product_images'])->findOrFail($id);

    // Return the view and pass the product data
   
    return view('product-detail', compact('product'));
}


    
}
