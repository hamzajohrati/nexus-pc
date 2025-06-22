<?php

namespace App\Http\Controllers;
use App\Models\Config;
use App\Services\Cart;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(private Cart $cart, private CheckoutService $flow) {}

    public function store()
    {
        $config = Config::first()->get();
        $order = $this->flow->place($this->cart);
        return redirect()->route('orders.show',$order)
            ->with('success','Order placed!, you will be Contacted shortly by our sales Rep to confirm your order on the number.'.$config[0]->phone);
    }
}

