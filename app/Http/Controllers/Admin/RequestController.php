<?php

namespace App\Http\Controllers\Admin;

use App\Models\Requests as Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $orders = Order::with([
            'user:id,email',
            'details.component:id,name',
            'details.pc:id,name',
        ])
            ->latest()
            ->paginate(15);

        $statuses = ['pending','in_progress','ready','shipped','delivered'];

        return view('admin.requests.index', compact('orders','statuses'));
    }

    public function create()
    {
        return view('admin.requests.form');
    }

    public function store(Requests $request)
    {
        $data = $request->validate([ "status"=>"required" ]);
        Order::create($data);
        return redirect()->route('admin.requests.index')->with('success','Created');
    }

    /* Update status only */
    public function update(Request $r, Order $request)
    {
        $r->validate([
            'status' => ['required','in:pending,in_progress,ready,shipped,delivered'],
        ]);

        $request->update(['status' => $r->status]);

        return back()->with('success',"Request #{$request->id} updated!");
    }

    /* Delete request + its details */
    public function destroy(Order $request)
    {
        $request->details()->delete();
        $request->delete();

        return back()->with('success','Request deleted');
    }
}
