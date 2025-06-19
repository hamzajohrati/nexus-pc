<?php

namespace App\Http\Controllers\Admin;

use App\Models\Requests;
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
        $items = Requests::latest()->paginate(20);
        return view('admin.requests.index', compact('items'));
    }

    public function create()
    {
        return view('admin.requests.form');
    }

    public function store(Requests $request)
    {
        $data = $request->validate([ "status"=>"required" ]);
        Requests::create($data);
        return redirect()->route('admin.requests.index')->with('success','Created');
    }

    public function edit(Requests $item)
    {
        return view('admin.requests.form', compact('item'));
    }

    public function update(Requests $request, Requests $item)
    {
        $data = $request->validate([ "status"=>"required" ]);
        $item->update($data);
        return redirect()->route('admin.requests.index')->with('success','Updated');
    }

    public function destroy(Requests $item)
    {
        $item->delete();
        return back()->with('success','Deleted');
    }
}
