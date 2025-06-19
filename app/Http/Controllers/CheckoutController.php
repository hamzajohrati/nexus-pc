<?php

namespace App\Http\Controllers;
use App\Services\Cart;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function __construct(private Cart $cart, private CheckoutService $flow) {}

    public function store()
    {
        $order = $this->flow->place($this->cart);
        return redirect()->route('orders.show',$order)
            ->with('success','Order placed!');
    }
}

