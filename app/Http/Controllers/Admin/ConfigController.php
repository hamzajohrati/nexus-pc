<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        $json   = file_get_contents(public_path('countries.json'));
        $countries  = json_decode($json, true);
        return view('admin.config.create',compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "country"=>"required",
            "city"=>"required",
            "adresse"=>"required",
            "phone"=>"required",
            "email"=>"required",
            "youtube"=>"nullable",
            "facebook"=>"nullable",
            "instagram"=>"nullable",
            "twitter"=>"required", ]);

        $config = Config::truncate();
        //Then Insert
        Config::create($data);
        return redirect()->route('admin.config.index')->with('success','Config Updated Successfully');
    }

}
