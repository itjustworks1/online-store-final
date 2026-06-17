<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories', [
            'category' => new Category(),
            'categories' => Category::query()->orderBy('name')->get(),
            'viewMode' => 'create',
        ]);
    }

    public function create()
    {
        return redirect()->route('admin.categories.index');
    }

    public function show(Category $category)
    {
        return view('admin.categories', [
            'category' => $category,
            'categories' => Category::query()->orderBy('name')->get(),
            'viewMode' => 'view',
        ]);
    }

    public function edit(Category $category)
    {
        return view('admin.categories', [
            'category' => $category,
            'categories' => Category::query()->orderBy('name')->get(),
            'viewMode' => 'edit',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => $this->makeUniqueSlug($validated['name']),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Категория создана');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $newSlug = Str::slug($validated['name'], '-');

        $category->update([
            'name' => $validated['name'],
            'slug' => $category->slug === $newSlug ? $category->slug : $this->makeUniqueSlug($validated['name'], $category->id),
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('admin.categories.show', $category)->with('success', 'Категория обновлена');
    }

    public function destroy(Category $category)
    {
        $category->products()->detach();
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }

    private function makeUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name, '-');
        $slug = $baseSlug;
        $index = 2;

        while (
            Category::query()
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
