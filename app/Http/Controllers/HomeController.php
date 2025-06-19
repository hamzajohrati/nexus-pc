<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PC;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        //get All Categories
        $categories = Category::all();
        $featuredProducts = PC::random(4);


        return view('pages.home',compact('categories','featuredProducts'));
    }
}
