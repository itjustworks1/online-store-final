<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
    }
    public function show(string $slug)
    {
        $products = Product::all();
        $product = $products->where('slug' ,$slug)->first();
        return view('products.view', ['product' => $product]);
    }
}
