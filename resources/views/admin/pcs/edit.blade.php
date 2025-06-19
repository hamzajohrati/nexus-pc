@extends('admin.layouts.app')

@section('title','Edit PC')

@section('content')
    <div class="card">
        <div class="card-title"><h4>Edit PC Build</h4></div>

        <div class="card-body w-75 mx-auto">
            <form action="{{ route('admin.pcs.update', $pc) }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- ─────────────────── 1. BASIC INFO ─────────────────── --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2">
                        <label for="name" class="col-form-label">Build Name</label>
                    </div>
                    <div class="col-md-7">
                        <input  id="name" name="name" type="text" maxlength="100"
                                class="form-control"
                                value="{{ old('name', $pc->name) }}">
                    </div>

                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input  class="form-check-input"
                                    type="checkbox"
                                    id="is_prebuilt"
                                    name="is_prebuilt"
                                {{ old('is_prebuilt', $pc->is_prebuilt) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_prebuilt">Pre-built</label>
                        </div>
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2">
                        <label for="description" class="col-form-label">Description</label>
                    </div>
                    <div class="col-md-7">
                    <textarea id="description" name="description"
                              class="form-control" maxlength="255"
                              rows="3">{{ old('description', $pc->description) }}</textarea>
                    </div>
                </div>

                {{-- Image --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2">
                        <label for="image" class="col-form-label">Image</label>
                    </div>
                    <div class="col-md-7">
                        @if($pc->img_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$pc->img_path) }}"
                                     alt="{{ $pc->name }}" class="img-thumbnail"
                                     style="max-height:120px">
                            </div>
                        @endif
                        <input class="form-control"
                               type="file"
                               id="image"
                               name="image"
                               accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted">Leave blank to keep existing image.</small>
                    </div>
                </div>

                {{-- ─────────────────── 2. COMPONENTS ─────────────────── --}}
                <h6 class="text-muted mb-3">Components & Quantities</h6>

                <table class="table align-middle">
                    <thead>
                    <tr>
                        <th style="width:24%">Category</th>
                        <th>Component</th>
                        <th style="width:140px">Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $cat)
                        @php
                            $sel = $selected[$cat->id] ?? null;  // ['id'=>,'qty'=>,'name'=>,'price'=>]
                        @endphp
                        <tr>
                            <td><i class="{{ $cat->icon }} me-1"></i>{{ $cat->category }}</td>

                            <td>
                                <select name="components[{{ $cat->id }}][id]"
                                        class="form-select component-select"
                                        data-category="{{ $cat->id }}">
                                    <option value="" hidden>— choose —</option>

                                    {{-- Ensure current choice appears even if now out of stock --}}
                                    @if($sel && !$cat->components->firstWhere('id',$sel['id']))
                                        <option value="{{ $sel['id'] }}"
                                                data-price="{{ $sel['price'] }}"
                                                selected>
                                            {{ $sel['name'] }} ({{ number_format($sel['price'],0) }} MAD)
                                            — out of stock
                                        </option>
                                    @endif

                                    @foreach($cat->components()->where('stock','>',0)->get() as $cmp)
                                        <option value="{{ $cmp->id }}"
                                                data-price="{{ $cmp->price }}"
                                            {{ old("components.$cat->id.id", $sel['id'] ?? null) == $cmp->id ? 'selected' : '' }}>
                                            {{ $cmp->name }} ({{ number_format($cmp->price,0) }} MAD)
                                        </option>
                                    @endforeach
                                </select>
                            </td>

                            <td>
                                <input  type="number" min="1" class="form-control qty-input"
                                        name="components[{{ $cat->id }}][qty]"
                                        value="{{ old("components.$cat->id.qty", $sel['qty'] ?? 1) }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {{-- ─────────────────── 3. TOTAL PRICE ─────────────────── --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-2"><label class="col-form-label">Total</label></div>
                    <div class="col-md-10">
                        <input id="total_view" class="form-control mb-1"
                               value="{{ number_format($pc->price,0) }} MAD" readonly>
                        <input id="total" name="total" type="hidden" value="{{ $pc->price }}">
                    </div>
                </div>

                {{-- Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="card-footer text-center">
                    <button class="btn btn-primary">
                        <i class="fa fa-save me-1"></i>Update PC
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            /* Build price map from in-stock components + selected ones */
            const priceMap = @json(
        $categories->flatMap(fn($c) =>
            $c->components->mapWithKeys(fn($cmp)=>[$cmp->id => $cmp->price]))
        ->merge(
            collect($selected)->mapWithKeys(fn($row)=>[$row['id'] => $row['price']]))
    );

            const selects   = document.querySelectorAll('.component-select');
            const qtyInputs = document.querySelectorAll('.qty-input');
            const totalIn   = document.getElementById('total');
            const totalView = document.getElementById('total_view');
            const fmt       = v => Intl.NumberFormat('en-MA',{maximumFractionDigits:0}).format(v)+' MAD';

            function calcTotal(){
                let sum = 0;
                selects.forEach(sel=>{
                    const id  = sel.value;
                    const qty = parseInt(sel.closest('tr').querySelector('.qty-input').value||1);
                    sum += (priceMap[id] || 0) * qty;
                });
                totalIn.value = sum;
                totalView.value = fmt(sum);
            }

            selects.forEach(sel => sel.addEventListener('change',  calcTotal));
            qtyInputs.forEach(q => q.addEventListener('input',     calcTotal));
            calcTotal(); // initial
        });
    </script>
@endpush
