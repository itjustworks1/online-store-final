<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ShoppingCartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(ShoppingCartService $cartService)
    {
        $items = $cartService->items();

        return view('cart.index', [
            'items' => $items,
            'total' => $cartService->total(),
            'count' => $cartService->count(),
        ]);
    }

    public function add(Request $request, Product $product, ShoppingCartService $cartService)
    {
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:'.$product->stock_quantity],
        ]);

        $quantity = (int) ($validated['quantity'] ?? 1);
        $cartService->add($product, $quantity);

        return back()->with('success', 'Товар добавлен в корзину.');
    }

    public function update(Request $request, int $identifier, ShoppingCartService $cartService)
    {
        $item = $cartService->getItem($identifier);

        if (! $item) {
            return back()->with('error', 'Позиция корзины не найдена.');
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:'.$item['product']->stock_quantity],
        ]);

        $cartService->update($identifier, (int) $validated['quantity']);

        return back()->with('success', 'Количество обновлено.');
    }

    public function remove(int $identifier, ShoppingCartService $cartService)
    {
        $cartService->remove($identifier);

        return back()->with('success', 'Позиция удалена из корзины.');
    }
}
