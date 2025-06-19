<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Pc;
use App\Models\PCComponent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PcController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index()
    {
        // eager load number of parts per PC
        $pcs = PC::withCount('items')
            ->latest()
            ->paginate(10);
        return view('admin.pcs.index', compact('pcs'));
    }

    public function create()
    {
        $categories = Category::with(['components' => fn ($q) => $q->where('stock','>',0)])
            ->get();
        return view('admin.pcs.create', compact('categories'));
    }

    public function store(Request $r)
    {

        $validated = $r->validate([
            'name'        => ['required','max:100'],
            'description' => ['required','max:255'],
        ]);
        if ($r->hasFile('image')) {
            $image = $r->file('image')->store('uploads/pcs','public');
        }
            $pc = PC::create([
                'name'        => $r->name,
                'is_prebuilt' => $r->boolean('is_prebuilt'),
                'price'       => $r->total,
                'description'=>$r->description,
                'img_path'=>$image
            ]);

            foreach  ($r->components as $catId => $row) {
                PCComponent::create([
                    'id_pc'        => $pc->id,
                    'id_component' => $row['id'],
                    'quantity'     => $row['qty'],
                ]);
            }

        return back()->with('success','PC created!');
    }

    public function update(Request $r, PC $pc)
    {
        /* ───────────────────────────────────────────────
        1. Validate
     ─────────────────────────────────────────────── */
        $r->validate([
            'name'        => ['required','max:100'],
            'description' => ['required','max:255'],
            'image'       => ['nullable','image','max:2048'],
            'components'           => ['array'],
            'components.*.id'      => ['required','exists:components,id'],
            'components.*.qty'     => ['required','integer','min:1'],
        ]);

        /* ───────────────────────────────────────────────
           2. Handle optional new image
        ─────────────────────────────────────────────── */
        $imgPath = $pc->img_path;                          // keep old one by default
        if ($r->hasFile('image')) {
            // delete previous file (optional but tidy)
            if ($imgPath) Storage::disk('public')->delete($imgPath);

            $imgPath = $r->file('image')->store('uploads/pcs', 'public');
        }

        /* ───────────────────────────────────────────────
           3. Persist changes inside a transaction
        ─────────────────────────────────────────────── */
        DB::transaction(function () use ($r, $pc, $imgPath) {

            // update PC main record
            $pc->update([
                'name'        => $r->name,
                'description' => $r->description,
                'is_prebuilt' => $r->boolean('is_prebuilt'),
                'price'       => $r->total,          // trusted from JS calc
                'img_path'    => $imgPath,
            ]);

            // wipe old component list and recreate
            $pc->items()->delete();                   // items() = hasMany PCComponent

            foreach ($r->components as $row) {
                PCComponent::create([
                    'id_pc'        => $pc->id,
                    'id_component' => $row['id'],
                    'quantity'     => $row['qty'],
                ]);
            }
        });

        return redirect()
            ->route('admin.pcs.index')
            ->with('success','PC updated!');
    }
    public function edit( $item)
    {
        $pc = PC::where('id',$item)->first();
        $categories = Category::with(['components' => fn ($q) => $q->where('stock', '>', 0)])
            ->get();

        /* Build array keyed by category_id:
           [ category_id => ['id'=>componentId, 'qty'=>n, 'name'=>…, 'price'=>…] ]
        */
        $selected = [];

        foreach ($pc->items as $item) {
            $comp = $item->component;           // eager-loaded via PC::items()->with('component')
            $cat  = $comp->id_category;

            $selected[$cat] = [
                'id'    => $item->id_component,
                'qty'   => $item->quantity,
                'name'  => $comp->name,
                'price' => $comp->price,
            ];
        }

        return view('admin.pcs.edit', compact('pc', 'categories', 'selected'));
    }


    public function destroy( $item)
    {
        $pc = PC::where('id',$item)->first();
        DB::transaction(function () use ($pc) {

            /* 1️⃣  Delete image file, if any */
            if ($pc->img_path) {
                Storage::disk('public')->delete($pc->img_path);
            }

            /* 2️⃣  Delete related rows in pc_components */
            $pc->items()->delete();      // items() = hasMany(PCComponent::class,'id_pc')

            /* 3️⃣  Delete the PC record itself */
            $pc->delete();
        });

        return back()->with('success', 'PC deleted!');
    }
}
