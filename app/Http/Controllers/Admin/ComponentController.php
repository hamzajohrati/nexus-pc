<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ComponentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $items = Component::with('category')->orderby('id','DESC')->get();
        return view('admin.components.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::orderBy('category')->get();
        return view('admin.components.create',compact('categories'));
    }

    public function store(Request $r)
    {
        $validated = $r->validate([
            'id_category' => ['required','exists:categories,id'],
            'name'        => ['required','max:100'],
            'description' => ['required','max:255'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'image'       => ['required','image','max:2048'],   // 2 MB
        ]);

        if ($r->hasFile('image')) {
            $validated['img_path'] = $r->file('image')->store('uploads/components','public');
        }

        Component::create($validated);

        return redirect()->route('admin.components.index')
            ->with('success','Component created!');
    }

    public function edit($item)
    {
        $component = Component::where('id',$item)->first();
        $categories = Category::orderBy('category')->get();
        return view('admin.components.edit', compact('component','categories'));
    }

    public function update(Request $r, Component $component)
    {
        $v = $r->validate([
            'id_category' => ['required','exists:categories,id'],
            'name'        => ['required','max:100'],
            'description' => ['nullable','max:255'],
            'price'       => ['required','numeric','min:0'],
            'stock'       => ['required','integer','min:0'],
            'image'       => ['nullable','image','max:2048'],
        ]);

        // Replace image if a new one uploaded
        if ($r->hasFile('image')) {
            // delete old file(s)
            Storage::disk('public')->delete($component->img_path);

            $v['img_path'] = $r->file('image')->store('uploads/components', 'public');
        }

        $component->update($v);

        return redirect()->route('admin.components.index')
            ->with('success','Component updated!');
    }

    public function destroy($item)
    {
        $component = Component::where('id',$item)->first();
        $path = $component->img_path;
        //Delete associated img from storage first
        Storage::disk('public')->delete($path);
        $component->delete();
        return back()->with('success','Deleted');
    }
}
