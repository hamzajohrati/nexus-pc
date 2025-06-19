<?php

namespace App\Http\Controllers;

use App\Models\PC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PrebuiltPCController extends Controller
{
    public function index(){
        $pcs = PC::where('is_prebuilt',1)->orderBy('id','desc')->get();
        return view('pages.prebuilt',compact('pcs'));
    }
}
