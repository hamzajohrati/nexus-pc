<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\Cart;
use App\Models\{
    Requests           as Order,
    RequestDetail,
    Component,
    PC,
    PCComponent
};
use Illuminate\Support\Str;

class CheckoutService
{
    /**
     * Turn the session cart into an Order and update stock.
     *
     * @throws ValidationException  when any component stock is insufficient
     */
    public function place(Cart $cart): Order
    {
        if ($cart->countLines() === 0) {
            throw ValidationException::withMessages(['cart' => 'Cart is empty.']);
        }

        /* ───────────────────────────────────────────────────────────────
           Run everything inside ONE DB transaction
        ─────────────────────────────────────────────────────────────── */
        return DB::transaction(function () use ($cart) {

            /* -----------------------------------------------------------
               1️⃣  Gather required component quantities
            ----------------------------------------------------------- */
            $need = [];   // [component_id => qty]
            $detailRows = [];   // rows we will insert into request_details

            foreach ($cart->items() as $line) {

                /* A. Stand-alone component lines */
                if ($line['type'] === 'component') {
                    $need[$line['id']] = ($need[$line['id']] ?? 0) + $line['qty'];

                    $detailRows[] = [
                        'type'   => 'component',
                        'id'     => $line['id'],
                        'qty'    => $line['qty'],
                    ];
                    continue;
                }

                /* B. Build lines – create real PC now, merge its needs once */
                if ($line['type'] === 'build') {
                    $result = $this->persistBuildLine($line);     // returns ['line'=>pc-line, 'need'=>[]]

                    // merge stock needs _once_
                    foreach ($result['need'] as $cid => $qty) {
                        $need[$cid] = ($need[$cid] ?? 0) + $qty;
                    }

                    $detailRows[] = [
                        'type' => 'pc',
                        'id'   => $result['line']['id'],
                        'qty'  => 1,
                    ];
                    continue;
                }

                /* C. Pre-built PC lines – fetch their components */
                if ($line['type'] === 'pc') {
                    foreach (PCComponent::where('id_pc', $line['id'])->get() as $row) {
                        $need[$row->id_component] =
                            ($need[$row->id_component] ?? 0) + ($row->quantity * $line['qty']);
                    }

                    $detailRows[] = [
                        'type' => 'pc',
                        'id'   => $line['id'],
                        'qty'  => $line['qty'],
                    ];
                }
            }

            /* -----------------------------------------------------------
               2️⃣  Lock component rows & verify stock
            ----------------------------------------------------------- */
            $components = Component::whereIn('id', array_keys($need))
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $insufficient = [];
            foreach ($need as $id => $qty) {
                $have = $components[$id]->stock ?? 0;
                if ($have < $qty) {
                    $insufficient[] = "#$id (need $qty / have $have)";
                }
            }
            if ($insufficient) {
                throw ValidationException::withMessages([
                    'stock' => 'Not enough stock for: '.implode(', ', $insufficient),
                ]);
            }

            /* -----------------------------------------------------------
               3️⃣  Create the order
            ----------------------------------------------------------- */
            $order = Order::create([
                'id_user'      => auth()->id(),
                'request_type' => 'PC',              // adjust if you use enum
                'status'       => 'pending',
                'total_price'  => $cart->total(),
            ]);

            /* insert details */
            foreach ($detailRows as $row) {
                RequestDetail::create([
                    'id_request'   => $order->id,
                    'id_pc'        => $row['type'] === 'pc'        ? $row['id'] : null,
                    'id_component' => $row['type'] === 'component' ? $row['id'] : null,
                    'quantity'     => $row['qty'],
                ]);
            }

            /* -----------------------------------------------------------
               4️⃣  Decrement stock exactly ONCE
            ----------------------------------------------------------- */
            foreach ($need as $id => $qty) {
                Component::where('id', $id)->decrement('stock', $qty);
            }

            $cart->clear();
            return $order;
        });
    }

    /**
     * Persist a temporary “build” cart line as a real PC + pc_components.
     * Returns:
     *   'line' => pc-type cart line  (id, price, …)
     *   'need' => [component_id => qty] for stock calculations
     */
    private function persistBuildLine(array $line): array
    {
        /* 1️⃣  Create PC skeleton */
        $pc = PC::create([
            'name'        => $line['name'] ?? ('Custom build '.Str::random(6)),
            'description' => 'Custom build via PC-builder',
            'is_prebuilt' => false,
            'id_user'     => auth()->id(),
            'price'       => 0,
        ]);

        /* 2️⃣  Attach components, gather needs */
        $needs = [];   // [cid => qty]
        foreach ($line['components'] as $row) {
            PCComponent::create([
                'id_pc'        => $pc->id,
                'id_component' => $row['id'],
                'quantity'     => $row['qty'],
            ]);
            $needs[$row['id']] = ($needs[$row['id']] ?? 0) + $row['qty'];
        }

        /* 3️⃣  Update PC price */
        $pc->refreshPrice();

        /* 4️⃣  Return transformed line + needs */
        return [
            'line' => [
                'type'  => 'pc',
                'id'    => $pc->id,
                'name'  => $pc->name,
                'price' => $pc->price,
                'qty'   => 1,
            ],
            'need' => $needs,
        ];
    }
}
