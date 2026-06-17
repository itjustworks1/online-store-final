<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index()
    {
        return view('admin.products', [
            'product' => new Product(),
            'products' => Product::latest()->get(),
            'viewMode' => 'create',
        ]);
    }

    public function create()
    {
        return redirect()->route('admin.products.index');
    }

    public function show(Product $product)
    {
        return view('admin.products', [
            'product' => $product,
            'products' => Product::latest()->get(),
            'viewMode' => 'view',
        ]);
    }

    public function edit(Product $product)
    {
        return view('admin.products', [
            'product' => $product,
            'products' => Product::latest()->get(),
            'viewMode' => 'edit',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'image' => 'nullable|string|url',
            'stock_quantity' => 'required|integer',
            'is_available' => 'sometimes|boolean',
        ]);

        Product::create([
            'name' => $validated['name'],
            'slug' => $this->makeUniqueSlug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $validated['image'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'is_available' => $validated['is_available'] ?? false,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Товар создан');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'image' => 'nullable|string|url',
            'stock_quantity' => 'required|integer',
            'is_available' => 'sometimes|boolean',
        ]);

        $newSlug = Str::slug($validated['name'], '-');

        $product->update([
            'name' => $validated['name'],
            'slug' => $product->slug === $newSlug ? $product->slug : $this->makeUniqueSlug($validated['name'], $product->id),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $validated['image'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'is_available' => $validated['is_available'] ?? false,
        ]);

        return redirect()->route('admin.products.show', $product)->with('success', 'Товар обновлен');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Товар удален');
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name, '-');
        $slug = $baseSlug;
        $index = 2;

        while (
            Product::query()
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$index;
            $index++;
        }

        return $slug;
    }
}
