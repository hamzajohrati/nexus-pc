@extends('admin.layouts.app')

@section('title','Add PC')

@section('content')
    <div class="card">
        <div class="card-title"><h4>New PC Build</h4></div>

        <div class="card-body w-75 mx-auto">
            <form action="{{ route('admin.pcs.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ───────────────────────────────────────────
                     1.  BASIC INFO
                ─────────────────────────────────────────── --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Build Name</label>
                    </div>
                    <div class="col-md-7">
                        <input type="text" id="name" name="name"
                               class="form-control" maxlength="100"
                               value="{{ old('name') }}">
                    </div>
                    {{-- Pre-built switch --}}
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    id="is_prebuilt"
                                    name="is_prebuilt"
                                {{ old('is_prebuilt') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_prebuilt">
                                Pre-built
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2">
                        <label for="description" class="col-form-label">Description</label>
                    </div>
                    <div class="col-md-7">
                        <textarea  id="description" name="description"
                               class="form-control" maxlength="255">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="image" class="col-form-label">Product Image</label>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="file" id="image" name="image" accept="image/png,image/jpeg,image/webp">
                    </div>
                </div>

                {{-- ───────────────────────────────────────────
                     2.  COMPONENTS & QUANTITIES
                ─────────────────────────────────────────── --}}
                <h6 class="text-muted mb-3">Components & Quantities</h6>

                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th style="width:24%">Category</th>
                        <th>Component (only items in stock)</th>
                        <th style="width:140px">Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $cat)
                        <tr>
                            <td>
                                <i class="{{ $cat->icon }} me-1"></i>{{ $cat->category }}
                            </td>

                            {{-- Component select --}}
                            <td>
                                <select name="components[{{ $cat->id }}][id]"
                                        class="form-select component-select"
                                        data-category="{{ $cat->id }}">
                                    <option value="" hidden>— choose —</option>
                                    @foreach($cat->components()->where('stock','>',0)->get() as $cmp)
                                        <option value="{{ $cmp->id }}"
                                                data-price="{{ $cmp->price }}"
                                            {{ old("components.$cat->id.id") == $cmp->id ? 'selected' : '' }}>
                                            {{ $cmp->name }} ({{ number_format($cmp->price,0) }} MAD)
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            {{-- Quantity --}}
                            <td>
                                <input  type="number"
                                        min="1"
                                        name="components[{{ $cat->id }}][qty]"
                                        value="{{ old("components.$cat->id.qty",1) }}"
                                        class="form-control qty-input">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- ───────────────────────────────────────────
                     3.  TOTAL PRICE (computed via JS)
                ─────────────────────────────────────────── --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2"><label class="col-form-label">Total</label></div>
                    <div class="col-md-10">
                        <input id="total_view" class="form-control mb-1" value="0 MAD" readonly>
                        <input id="total" name="total" type="hidden" value="0">
                    </div>
                </div>

                {{-- Validation errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-footer text-center">
                    <button class="btn btn-primary">
                        <i class="fa fa-plus me-1"></i>Add PC
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* Build a map {component_id: price} for instant look-ups */
            const priceMap = @json(
        $categories
            ->flatMap(fn($c)=>$c->components->mapWithKeys(fn($cmp)=>[$cmp->id => $cmp->price]))
    );

            const selects  = document.querySelectorAll('.component-select');
            const qtyInputs= document.querySelectorAll('.qty-input');
            const totalIn  = document.getElementById('total');
            const totalOut = document.getElementById('total_view');
            const fmt      = v => Intl.NumberFormat('en-MA',{maximumFractionDigits:0}).format(v)+' MAD';

            function calcTotal(){
                let sum = 0;
                selects.forEach(sel => {
                    const id   = sel.value;
                    const qty  = parseInt(sel.closest('tr').querySelector('.qty-input').value || 1);
                    sum += (priceMap[id] || 0) * qty;
                });
                totalIn.value  = sum;
                totalOut.value = fmt(sum);
            }

            selects.forEach(sel => sel.addEventListener('change',  calcTotal));
            qtyInputs.forEach(q => q.addEventListener('input',     calcTotal));
            calcTotal();                                   // run once on page load
        });
    </script>
@endpush
