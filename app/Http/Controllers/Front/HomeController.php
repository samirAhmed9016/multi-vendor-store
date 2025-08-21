<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // $products = Product::with('category')->active()->latest()->get();
        $products = Product::with('category')->active()->latest()->take(12)->get();
        // dd($products);

        return view('front.home', compact('products'));
    }
}
