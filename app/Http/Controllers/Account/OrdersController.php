<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(){
        $orders = Order::with(['user', 'status'])->where('user_id', \Auth::user()->id)->orderByDesc('id')->paginate(10);
            return view('account/orders/index', compact('orders'));
    }
}
