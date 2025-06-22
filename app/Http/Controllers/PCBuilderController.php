<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Component;
use App\Models\PC;
use App\Models\PCComponent;
use App\Services\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PCBuilderController extends Controller
{
    public function index()
    {
        // eager-load components in stock, sorted by price ASC
        $categories = Category::with([
            'components' => fn($q) => $q->where('stock','>',0)->orderBy('price')
        ])->orderBy('category')->get();

        return view('pages.builder', compact('categories'));
    }
    public function add(Request $r, Cart $cart)
    {
        $data = $r->validate([
            'name'               => ['required','max:100'],
            'components'         => ['required','array'],
            'components.*.id'    => ['required','exists:components,id'],
            'components.*.qty'   => ['required','integer','min:1'],
        ]);

        /* calculate price once (sum of parts × qty) */
        $price = collect($data['components'])
            ->sum(fn($row) =>
                Component::find($row['id'])->price * $row['qty']);

        $cart->addBuild($data['name'], $data['components'], $price);

        return redirect()->route('cart')
            ->with('success','Build added to cart!');
    }
}
