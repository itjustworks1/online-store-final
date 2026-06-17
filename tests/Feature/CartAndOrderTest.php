<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartAndOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cart_is_stored_in_session_and_can_be_updated_and_removed(): void
    {
        $product = Product::factory()->create([
            'name' => 'Guest Product',
            'slug' => 'guest-product',
            'price' => 120.00,
            'stock_quantity' => 7,
            'is_available' => true,
        ]);

        $this->from(route('products.show', $product))
            ->post(route('cart.add', $product), ['quantity' => 2])
            ->assertRedirect(route('products.show', $product));

        $this->assertSame(2, session('cart.items.'.$product->id));

        $this->from(route('cart.index'))
            ->patch(route('cart.update', $product->id), ['quantity' => 4])
            ->assertRedirect(route('cart.index'));

        $this->assertSame(4, session('cart.items.'.$product->id));

        $this->from(route('cart.index'))
            ->delete(route('cart.remove', $product->id))
            ->assertRedirect(route('cart.index'));

        $this->assertNull(session('cart.items.'.$product->id));
    }

    public function test_authenticated_cart_is_persisted_in_database(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create([
            'name' => 'DB Product',
            'slug' => 'db-product',
            'price' => 99.50,
            'stock_quantity' => 10,
            'is_available' => true,
        ]);

        $this->actingAs($user)
            ->from(route('products.show', $product))
            ->post(route('cart.add', $product), ['quantity' => 3])
            ->assertRedirect(route('products.show', $product));

        $cart = Cart::query()->where('user_id', $user->id)->first();

        $this->assertNotNull($cart);
        $this->assertDatabaseHas('cart_items', [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    public function test_checkout_creates_order_clears_cart_and_updates_stock(): void
    {
        $user = User::factory()->create([
            'name' => 'Buyer',
            'email' => 'buyer@example.com',
            'phone' => '+7 999 111-22-33',
        ]);

        $product = Product::factory()->create([
            'name' => 'Checkout Product',
            'slug' => 'checkout-product',
            'price' => 250.00,
            'stock_quantity' => 5,
            'is_available' => true,
        ]);

        $this->actingAs($user)
            ->post(route('cart.add', $product), ['quantity' => 2]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'customer_name' => 'Buyer',
            'customer_phone' => '+7 999 111-22-33',
            'customer_email' => 'buyer@example.com',
            'shipping_address' => 'Moscow, Main street 1',
            'comment' => 'Call before delivery',
        ]);

        $order = Order::query()->where('user_id', $user->id)->first();

        $this->assertNotNull($order);
        $response->assertStatus(302);
        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'total_amount' => 500.00,
            'status' => 'new',
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 250.00,
        ]);
        $this->assertDatabaseMissing('cart_items', [
            'product_id' => $product->id,
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 3,
            'is_available' => true,
        ]);
    }

    public function test_customer_can_view_their_orders(): void
    {
        $user = User::factory()->create();
        $order = Order::query()->create([
            'user_id' => $user->id,
            'total_amount' => 123.45,
            'status' => 'new',
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => '+7 999 000-00-00',
            'shipping_address' => 'Some address',
        ]);

        $this->actingAs($user)
            ->get(route('orders.my'))
            ->assertOk()
            ->assertSee((string) $order->id);
    }
}
