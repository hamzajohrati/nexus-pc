<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $items = Category::orderby('id','DESC')->get();
        return view('admin.categories.index', compact('items'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([ "category"=>"required","color"=>"required","description"=>"required","icon"=>"required" ]);
        Category::create($data);
        return redirect()->route('admin.categories.index')->with('success','Created');
    }

    public function edit($item)
    {
        $category = Category::where("id",$item)->first();
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $item)
    {
        $category = Category::where("id",$item)->first();

        $data = $request->validate([ "category"=>"required","color"=>"required","description"=>"required","icon"=>"required" ]);


        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success','Updated');
    }

    public function destroy($item)
    {
        $category = Category::where("id",$item)->first();
        $category->delete();
        return back()->with('success','Deleted');
    }
}
