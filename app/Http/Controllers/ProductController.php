<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->string('search'));
        $categorySlug = trim((string) $request->string('category'));
        $sort = trim((string) $request->string('sort', 'newest'));

        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with('categories')
            ->search($search)
            ->categorySlug($categorySlug)
            ->sortBy($sort)
            ->paginate(9)
            ->withQueryString();

        $activeCategory = $categorySlug !== ''
            ? $categories->firstWhere('slug', $categorySlug)
            : null;

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'search' => $search,
            'sort' => $sort,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(Product $product)
    {
        $product->load('categories');

        $relatedProducts = Product::query()
            ->with('categories')
            ->where('id', '!=', $product->getKey())
            ->whereHas('categories', function ($query) use ($product): void {
                $query->whereIn('id', $product->categories->pluck('id'));
            })
            ->latest()
            ->take(4)
            ->get();

        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
