<?php

namespace App\Http\Controllers;

use App\Models\PC;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PrebuiltPCController extends Controller
{
    public function index(Request $r){
        // ── 1. Sanitise sort option ─────────────────────────────────────────
        $sort = $r->input('sort', 'created_desc');   // default newest
        $dir  = str_contains($sort, '_asc')  ? 'asc' : 'desc';
        $col  = str_starts_with($sort, 'price') ? 'price' : 'created_at';

        // ── 2. Query only pre-built PCs ─────────────────────────────────────
        $pcs = PC::with([
            'components.category:id,category',   // ← add category name
        ])
            ->where('is_prebuilt', true)
            ->orderBy($col, $dir)
            ->paginate(5)
            ->appends($r->only('sort'));        // keep sort in links
        return view('pages.prebuilt',compact('pcs','sort'));
    }
}
