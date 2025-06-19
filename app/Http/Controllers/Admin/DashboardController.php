<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Category,Component,Pc,Requests as PcRequest,User};
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'categories' => Category::count(),
            'components' => Component::count(),
            'pcs'        => Pc::count(),
            'requests'   => PcRequest::count(),
            'users'      => User::count(),
        ];
        return view('admin.dashboard.index', compact('stats'));
    }
}
