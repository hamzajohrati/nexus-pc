{{-- resources/views/builder/index.blade.php --}}
@extends('layouts.app')
@section('title','PC Builder')

@section('content')
    <div class="container my-4">
        <h3 class="mb-4">Custom PC Builder</h3>

        <form action="{{ route('builder.add') }}" method="POST" id="buildForm">
            @csrf

            {{-- build name --}}
            <div class="mb-4 w-50">
                <label class="form-label">Build name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name', 'My custom build') }}" maxlength="100">
            </div>

            {{-- category cards --}}
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($categories as $cat)
                    {{-- CARD --}}
                    <div class="col">
                        <div class="card h-100 shadow-sm">

                            {{-- image preview --}}
                            <img src="{{ asset('assets/img/placeholder-comp.svg') }}"
                                 class="card-img-top selected-img"
                                 data-cat="{{ $cat->id }}"
                                 style="height:140px;object-fit:cover">

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <i class="{{ $cat->icon }} me-2"></i>{{ $cat->category }}
                                </h5>

                                <p class="selected-name text-muted my-3"
                                   data-cat="{{ $cat->id }}">
                                    <em>No component chosen</em>
                                </p>

                                <div class="mt-auto d-flex justify-content-between">
                            <span class="fw-bold selected-price"
                                  data-cat="{{ $cat->id }}">0 MAD</span>

                                    <button type="button"
                                            class="btn btn-outline-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $cat->id }}">
                                        <i class="fa fa-plus me-1"></i>Add / Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL --}}
                    <div class="modal fade" id="modal-{{ $cat->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Choose {{ $cat->category }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <img src="{{ asset('assets/img/placeholder-comp.svg') }}"
                                         class="img-fluid mb-3 modal-preview"
                                         data-cat="{{ $cat->id }}">

                                    <select class="form-select component-select"
                                            data-cat="{{ $cat->id }}">
                                        <option value="" hidden>— choose —</option>
                                        @foreach($cat->components as $cmp)
                                            <option  value="{{ $cmp->id }}"
                                                     data-price="{{ $cmp->price }}"
                                                     data-img="{{ $cmp->img_path ? asset('storage/'.$cmp->img_path) : asset('assets/img/placeholder-comp.svg') }}">
                                                {{ $cmp->name }} ({{ number_format($cmp->price,0) }} MAD)
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="mt-3">
                                        <input type="number" min="1" value="1"
                                               class="form-control qty-input"
                                               data-cat="{{ $cat->id }}">
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button"
                                            class="btn btn-danger save-btn"
                                            data-cat="{{ $cat->id }}">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- total + submit --}}
            <div class="mt-4 d-flex justify-content-between align-items-center">
                <h5>Total: <span id="total" class="fw-bold">0 MAD</span></h5>

                <button type="submit" class="btn btn-danger" id="addBtn" disabled>
                    <i class="fa fa-cart-plus me-1"></i>Add build to cart
                </button>
            </div>
        </form>
    </div>
@endsection


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const placeholder = "{{ asset('img/placeholder-comp.svg') }}";
            const fmt   = v => Intl.NumberFormat('en-MA',{maximumFractionDigits:0}).format(v)+' MAD';
            const total = document.getElementById('total');
            const addBtn= document.getElementById('addBtn');

            /* live preview in modal when user picks an option */
            document.querySelectorAll('.component-select').forEach(sel=>{
                sel.addEventListener('change', () => {
                    const cat  = sel.dataset.cat;
                    const img  = sel.selectedOptions[0]?.dataset.img || placeholder;
                    document.querySelector(`.modal-preview[data-cat="${cat}"]`).src = img;
                });
            });

            /* Save click: reflect choice in card & hidden inputs */
            document.querySelectorAll('.save-btn').forEach(btn=>{
                btn.addEventListener('click', () => {
                    const cat   = btn.dataset.cat;
                    const modal = btn.closest('.modal');
                    const sel   = modal.querySelector('.component-select');
                    const opt   = sel.selectedOptions[0];
                    if(!opt) return;

                    const qty  = modal.querySelector('.qty-input').value || 1;
                    const id   = opt.value;
                    const name = opt.textContent.trim();
                    const price= parseFloat(opt.dataset.price || 0);
                    const img  = opt.dataset.img || placeholder;

                    /* update card */
                    document.querySelector(`.selected-name[data-cat="${cat}"]`).textContent = name;
                    document.querySelector(`.selected-price[data-cat="${cat}"]`).textContent = fmt(price * qty);
                    document.querySelector(`.selected-img[data-cat="${cat}"]`).src = img;

                    /* hidden inputs (create/update) */
                    let idInp  = document.querySelector(`input[name="components[${cat}][id]"]`);
                    let qtyInp = document.querySelector(`input[name="components[${cat}][qty]"]`);
                    if(!idInp){
                        idInp  = document.createElement('input');
                        qtyInp = document.createElement('input');
                        idInp.type = qtyInp.type = 'hidden';
                        idInp.name = `components[${cat}][id]`;
                        qtyInp.name= `components[${cat}][qty]`;
                        document.getElementById('buildForm').append(idInp, qtyInp);
                    }
                    idInp.value  = id;
                    qtyInp.value = qty;

                    recalcTotal();
                    bootstrap.Modal.getInstance(modal).hide();
                });
            });

            function recalcTotal(){
                let sum = 0, chosen = 0;
                document.querySelectorAll('input[name$="[id]"]').forEach(idInput=>{
                    const cat   = idInput.name.match(/components\[(\d+)]/)[1];
                    const price = document.querySelector(`.selected-price[data-cat="${cat}"]`).textContent;
                    sum += parseFloat(price.replace(/\D/g,'')) || 0;
                    chosen++;
                });
                total.textContent = fmt(sum);
                addBtn.disabled   = (chosen === 0);
            }
        });
    </script>
@endpush
