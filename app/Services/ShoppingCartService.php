<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Cart_item;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ShoppingCartService
{
    public function source(): string
    {
        return Auth::check() ? 'database' : 'session';
    }

    public function count(): int
    {
        return $this->items()->sum('quantity');
    }

    public function total(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    public function items(): Collection
    {
        return $this->source() === 'database'
            ? $this->databaseItems()
            : $this->sessionItems();
    }

    public function getItem(int $identifier): ?array
    {
        return $this->items()->firstWhere('identifier', $identifier);
    }

    public function add(Product $product, int $quantity = 1): void
    {
        $quantity = max(1, $quantity);

        if ($this->source() === 'database') {
            $cart = $this->resolveDatabaseCart();
            $item = $cart->cartItems()->firstOrNew(['product_id' => $product->id]);
            $item->quantity = min($product->stock_quantity, (int) $item->quantity + $quantity);
            $item->save();

            return;
        }

        $items = $this->sessionCartItems();
        $current = (int) ($items[$product->id] ?? 0);
        $items[$product->id] = min($product->stock_quantity, $current + $quantity);

        if ($items[$product->id] <= 0) {
            unset($items[$product->id]);
        }

        $this->storeSessionCartItems($items);
    }

    public function update(int $identifier, int $quantity): void
    {
        if ($quantity <= 0) {
            $this->remove($identifier);

            return;
        }

        if ($this->source() === 'database') {
            $cart = $this->resolveDatabaseCart();
            $item = $cart->cartItems()->with('product')->findOrFail($identifier);
            if (! $item->product) {
                $item->delete();

                return;
            }
            $item->quantity = min($item->product->stock_quantity, $quantity);
            $item->save();

            return;
        }

        $items = $this->sessionCartItems();
        $product = Product::query()->find($identifier);

        if (! $product) {
            unset($items[$identifier]);
            $this->storeSessionCartItems($items);

            return;
        }

        $items[$identifier] = min($product->stock_quantity, $quantity);

        if ($items[$identifier] <= 0) {
            unset($items[$identifier]);
        }

        $this->storeSessionCartItems($items);
    }

    public function remove(int $identifier): void
    {
        if ($this->source() === 'database') {
            $cart = $this->resolveDatabaseCart();
            $cart->cartItems()->whereKey($identifier)->delete();

            return;
        }

        $items = $this->sessionCartItems();
        unset($items[$identifier]);
        $this->storeSessionCartItems($items);
    }

    public function clear(): void
    {
        if ($this->source() === 'database') {
            $cart = $this->resolveDatabaseCart();
            $cart->cartItems()->delete();

            return;
        }

        session()->forget('cart');
    }

    public function resolveCheckoutItems(): Collection
    {
        return $this->items()->filter(fn (array $item): bool => isset($item['product']) && $item['quantity'] > 0)->values();
    }

    protected function databaseItems(): Collection
    {
        $cart = $this->resolveDatabaseCart();

        return $cart->cartItems()
            ->with('product')
            ->get()
            ->map(function (Cart_item $item): array {
                $product = $item->product;

                if (! $product) {
                    return [
                        'identifier' => $item->id,
                        'product_id' => null,
                        'product' => null,
                        'quantity' => 0,
                        'subtotal' => 0,
                    ];
                }

                $quantity = (int) $item->quantity;
                $price = (float) $product->price;

                return [
                    'identifier' => $item->id,
                    'product_id' => $product->id,
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity,
                ];
            });
    }

    protected function sessionItems(): Collection
    {
        $items = $this->sessionCartItems();

        if ($items === []) {
            return collect();
        }

        $products = Product::query()
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        return collect($items)
            ->map(function (int $quantity, int $productId) use ($products): ?array {
                $product = $products->get($productId);

                if (! $product || $quantity <= 0) {
                    return null;
                }

                $quantity = min($product->stock_quantity, $quantity);

                return [
                    'identifier' => $product->id,
                    'product_id' => $product->id,
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => (float) $product->price * $quantity,
                ];
            })
            ->filter(fn (array $item): bool => $item['product'] !== null && $item['quantity'] > 0)
            ->values();
    }

    protected function resolveDatabaseCart(): Cart
    {
        $cart = Cart::query()->firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => session()->getId()]
        );

        $this->mergeSessionItemsIntoDatabaseCart($cart);

        return $cart->loadMissing('cartItems.product');
    }

    protected function mergeSessionItemsIntoDatabaseCart(Cart $cart): void
    {
        $items = $this->sessionCartItems();

        if ($items === []) {
            return;
        }

        $products = Product::query()
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        foreach ($items as $productId => $quantity) {
            $product = $products->get((int) $productId);

            if (! $product || $quantity <= 0) {
                continue;
            }

            $cartItem = $cart->cartItems()->firstOrNew(['product_id' => $product->id]);
            $cartItem->quantity = min($product->stock_quantity, (int) $cartItem->quantity + $quantity);
            $cartItem->save();
        }

        session()->forget('cart');
    }

    protected function sessionCartItems(): array
    {
        return session()->get('cart.items', []);
    }

    protected function storeSessionCartItems(array $items): void
    {
        session()->put('cart.items', $items);
    }
}
