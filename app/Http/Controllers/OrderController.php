<?php

namespace App\Http\Controllers;

use App\Models\Requests as Order;   // your model for the `requests` table
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $req)
    {
        $orders = Order::where('id_user', $req->user()->id)
            ->latest()                      // newest → oldest
            ->withCount('details')          // number of items
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }
    public function show(Order $order)
    {
        // make sure the logged-in user owns this order
        abort_unless($order->id_user === auth()->id(), 403);

        // eager-load details + the related component / pc
        $order->load([
            'details.component:id,name,price,img_path',
            'details.pc:id,name,price,img_path',
        ]);

        return view('orders.show', compact('order'));
    }
}
