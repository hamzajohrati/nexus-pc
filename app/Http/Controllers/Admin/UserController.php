<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $items = User::orderby('id','DESC')->get();
        return view('admin.users.index', compact('items'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // Validate (with custom message for phone)
        $data = $request->validate([
            'email'    => ['required', 'email', 'unique:users'],
            'phone_number'    => ['required', 'regex:/^\+212[5-7]\d{8}$/'],
            'password' => ['required', 'min:8'],
        ]);

        //  Post-process
        $data['password'] = bcrypt($data['password']);                 // hash
        $data['role']     = $request->boolean('role') ? 'admin' : 'user'; // one-liner role

        //  Persist
        User::create($data);

        //   Redirect with flash
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created!');
    }


    public function edit($item)
    {
        $user = User::where('id',$item)->first();
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $item)
    {
        $data = $request->validate([ "email"=>"required|email" ]);
        $item->update($data);
        return redirect()->route('admin.users.index')->with('success','Updated');
    }

    public function destroy($item)
    {
        $user = User::where('id',$item)->first();
        $user->delete();
        return back()->with('success','Deleted');
    }
}
