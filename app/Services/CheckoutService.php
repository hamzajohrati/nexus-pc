<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\{Requests as Order, RequestDetail};
use App\Services\Cart;

class CheckoutService
{
    public function place(Cart $cart): Order
    {
        abort_if(!$cart->countLines(), 400, 'Cart empty');

        return DB::transaction(function () use ($cart) {

            $order = Order::create([
                'id_user'      => auth()->id(),
                'request_type' => $cart->items()->contains(fn($i)=>$i['type']=='component') ? 'Component' : 'PC',
                'status'       => 'pending',
                'total_price'  => $cart->total(),
            ]);

            foreach ($cart->items() as $line) {
                RequestDetail::create([
                    'id_request'   => $order->id,
                    'id_component' => $line['type']=='component' ? $line['id'] : null,
                    'id_pc'        => $line['type']=='pc'        ? $line['id'] : null,
                    'quantity'     => $line['qty'],
                ]);
            }

            $cart->clear();
            return $order;
        });
    }
}
