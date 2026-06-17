<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\ShoppingCartService;
use App\Rules\PhoneDigitsRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function create(ShoppingCartService $cartService): View|RedirectResponse
    {
        $items = $cartService->items();

        if ($items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Корзина пуста.');
        }

        return view('orders.create', [
            'items' => $items,
            'total' => $cartService->total(),
        ]);
    }

    public function store(Request $request, ShoppingCartService $cartService): RedirectResponse
    {
        $items = $cartService->items();

        if ($items->isEmpty()) {
            return redirect()->route('products.index')->with('error', 'Корзина пуста.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20', new PhoneDigitsRule()],
            'customer_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = DB::transaction(function () use ($validated, $cartService, $items): Order {
            $products = Product::query()
                ->whereIn('id', $items->pluck('product_id'))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);

                if (! $product || $product->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'cart' => 'Для одного из товаров недостаточно остатка на складе.',
                    ]);
                }
            }

            $order = Order::query()->create([
                'user_id' => Auth::id(),
                'total_amount' => $items->sum('subtotal'),
                'status' => 'new',
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'customer_email' => $validated['customer_email'],
                'shipping_address' => $validated['shipping_address'],
                'comment' => $validated['comment'] ?? null,
            ]);

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);

                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);

                if ($product->fresh()->stock_quantity <= 0) {
                    $product->forceFill(['is_available' => false])->save();
                }
            }

            return $order;
        });

        $cartService->clear();

        if (Auth::check()) {
            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Заказ успешно оформлен.');
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Заказ №'.$order->id.' успешно оформлен.');
    }

    public function myOrders(): View
    {
        $orders = Order::query()
            ->with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $user = Auth::user();

        abort_unless(
            $user && ($order->user_id === $user->id || in_array($user->role, ['admin', 'order_manager'], true)),
            403
        );

        $order->load('orderItems.product', 'user');

        return view('orders.show', compact('order'));
    }
}
