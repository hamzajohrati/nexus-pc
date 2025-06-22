<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Models\{PC, Component};

class Cart
{
    /** All cart data lives under this session key. */
    protected string $key = 'cart';

    /* ---------- helpers ---------- */

    /** Entire cart as a collection keyed by rowId. */
    public function items(): Collection
    {
        return collect(session($this->key, []));
    }

    public function clear(): void         { session()->forget($this->key); }
    public function countLines(): int     { return $this->items()->count(); }
    public function totalItems(): int     { return $this->items()->sum('qty'); }
    public function total(): float        { return $this->items()->sum(fn($i) => $i['qty']*$i['price']); }

    /* ---------- line operations ---------- */

    public function addPC(int $pcId, int $qty = 1): void
    {
        $pc = PC::findOrFail($pcId);
        $this->put('pc', $pc->id, $pc->name, $pc->price, $qty, $pc->img_path);
    }

    public function addComponent(int $compId, int $qty = 1): void
    {
        $c = Component::findOrFail($compId);
        $this->put('component', $c->id, $c->name, $c->price, $qty, $c->img_path);
    }

    public function update(string $rowId, int $qty): void
    {
        $cart = $this->items();
        ($qty <= 0) ? $cart->forget($rowId) : $cart[$rowId]['qty'] = $qty;
        session([$this->key => $cart]);
    }

    public function remove(string $rowId): void  { $this->update($rowId, 0); }

    /* ---------- internal ---------- */

    private function put(string $type, int $id, string $name, float $price, int $qty, ?string $img_path): void
    {
        $rowId = $type.'-'.$id;                     // e.g. pc-5   or component-17
        $cart  = $this->items();

        $cart[$rowId] = [
            'rowId'  => $rowId,
            'type'   => $type,                      // "pc" | "component"
            'id'     => $id,
            'name'   => Str::limit($name, 80),
            'price'  => $price,
            'img_path'=> $img_path,
            'qty'    => ($cart[$rowId]['qty'] ?? 0) + $qty,
        ];

        session([$this->key => $cart]);
    }

    public function addBuild(string $name, array $rows, float $price): void
    {
        $rowId = 'build-'.Str::uuid();      // unique temp id
        $cart  = $this->items();

        $cart[$rowId] = [
            'rowId'     => $rowId,
            'type'      => 'build',
            'name'      => Str::limit($name, 80),
            'price'     => $price,
            'qty'       => 1,
            'components'=> $rows,           // each: ['id'=>, 'qty'=>]
        ];

        session([$this->key => $cart]);
    }
}
