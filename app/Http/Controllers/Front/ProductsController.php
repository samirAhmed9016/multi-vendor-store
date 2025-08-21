<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // Get latest products with category, paginated
        $products = Product::with('category')->latest()->paginate(8);

        return view('front.home', compact('products'));
    }

    public function show(Product $product)
    {
        // Load category relation for the product
        $product->load('category');

        // dd($product);
        // You may want to create a 'front.product' view for product details
        return view('front.products.show', compact('product'));
        // dd($product);
    }
}
