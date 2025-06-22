<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Component;
use Illuminate\Http\Request;

class ComponentsController extends Controller
{
    public function index(Request $r){
        $categories = Category::orderBy('category')->get();

        // validate + sanitise the sort option
        $sort = $r->input('sort', 'created_desc');
        $dir  = str_contains($sort, '_asc') ? 'asc' : 'desc';
        $col  = str_starts_with($sort, 'price') ? 'price' : 'created_at';

        $components = Component::when($r->cat, fn ($q, $catId) =>
        $q->where('id_category', $catId))
            ->where('stock','>',0)
            ->orderBy($col, $dir)
            ->paginate(5)
            ->appends($r->only('cat','sort')); // keep params in links

        return view('pages.components', compact('categories','components','sort'));
    }
}
