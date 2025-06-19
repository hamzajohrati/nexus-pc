<?php

namespace App\Http\Controllers;

use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private Cart $cart) {}

    public function index()    { return view('pages.cart', ['cart'=>$this->cart]); }
    public function addPC($id) { $this->cart->addPC($id);  return back(); }
    public function addComp($id){$this->cart->addComponent($id); return back(); }
    public function update(Request $r,$row){ $this->cart->update($row,$r->qty); return back();}
    public function remove($row=null){ $row ? $this->cart->remove($row) : $this->cart->clear(); return back();}
}

