<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.products', compact('product'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        Category::factory()->create([
            'name' => $validated['name'],
            "slug" => Str::slug($validated['name'], '-'),
            'description' => $validated['description'],
        ]);

//        return redirect()->route('home')->with('success', 'Post created successfully');
    }

    public function update(Request $request)
    {

    }
}
