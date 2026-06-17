<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $count_product = Product::count();
        $count_order = Order::count();
        $count_user = User::count();
        $last_orders = Order::latest()->limit(5)->get();
        $products = Product::all()->where('stock_quantity', '<=', 5);
//        dd($products);
        return view('admin.dashboard', compact('count_product', 'count_order', 'count_user', 'last_orders', 'products'));
    }
}
