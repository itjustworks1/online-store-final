<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Product $product)
    {
        return view('admin.products', compact('product'));
    }
    public function show(Product $product)
    {
        return view('admin.products', compact('product'));
    }
    public function store(Request $request)
    {
//        dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => [
                'nullable',
                'string',
                'url',
//                function ($attribute, $value, $fail) {
//                    // 1. Быстрая проверка по расширению в самой ссылке
//                    $extension = strtolower(pathinfo(parse_url($value, PHP_URL_PATH), PATHINFO_EXTENSION));
//                    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
//                        return $fail('Ссылка должна вести на изображение в формате JPG, JPEG или PNG.');
//                    }
//
//                    // 2. Отправляем быстрый HEAD-запрос, чтобы не скачивать весь файл, а узнать только его свойства
//                    $response = Http::timeout(3)->head($value);
//
//                    if (!$response->successful()) {
//                        return $fail('Не удалось получить доступ к изображению по ссылке.');
//                    }
//
//                    // Проверяем Content-Type (тип файла) со стороны сервера
//                    $contentType = $response->header('Content-Type');
//                    if (!Str::contains($contentType, ['image/jpeg', 'image/png'])) {
//                        return $fail('Сервер вернул некорректный тип файла. Разрешены только JPG и PNG.');
//                    }
//
//                    // Проверяем Content-Length (размер файла в байтах). 2 МБ = 2048 * 1024 = 2097152 байт
//                    $contentLength = $response->header('Content-Length');
//                    if ($contentLength && $contentLength > 2097152) {
//                        return $fail('Размер изображения по ссылке превышает максимальный размер 2 МБ.');
//                    }
//                }
                ],
//            'image' => 'string|nullable',
            'stock_quantity' => 'required|integer',
            'is_available' => 'sometimes|boolean',
        ]);
//        dd($validated);
        Product::factory()->create([
            'name' => $validated['name'],
            "slug" => Str::slug($validated['name'], '-'),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'image' => $validated['image'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'is_available' => $validated['is_available'] ?? false,
        ]);

//        return redirect()->route('home')->with('success', 'Post created successfully');
    }

    public function update(Request $request)
    {

    }
    public function delete(Request $request)
    {

    }
}
