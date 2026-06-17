<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'order_items.product'])->latest()->get();
        $order_items = Order_item::with(['order', 'product'])->latest()->get();

        return view('admin.orders', compact('orders', 'order_items'));
    }

    public function update(Request $request)
    {
    }

    public function show(Request $request)
    {
    }

    public function updateStatus(Request $request)
    {
    }
}
