<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::all();
        $order_items = Order_item::all();
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
