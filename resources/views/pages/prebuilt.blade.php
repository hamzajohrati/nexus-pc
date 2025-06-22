
@extends('layouts.app')
@section('title','Pre-built PCs')

@section('content')
<div class="container my-5">
  <h1 class="fw-bold mb-4">Pre-built Gaming PCs</h1>
    {{-- ─── Filter bar (only sort here) ───────────────────────────── --}}
    <div class="d-flex justify-content-end mb-3">
        <form>
            {{-- keep other query params if you add more later… --}}
            @foreach(request()->except(['sort','page']) as $k => $v)
                <input type="hidden" name="{{ $k }}" value="{{ $v }}">
            @endforeach

            <select name="sort" class="form-select" style="width:180px"
                    onchange="this.form.submit()">
                <option value="created_desc" {{ $sort=='created_desc' ? 'selected' : '' }}>
                    Newest
                </option>
                <option value="created_asc"  {{ $sort=='created_asc'  ? 'selected' : '' }}>
                    Oldest
                </option>
                <option value="price_asc"    {{ $sort=='price_asc'    ? 'selected' : '' }}>
                    Price ↑
                </option>
                <option value="price_desc"   {{ $sort=='price_desc'   ? 'selected' : '' }}>
                    Price ↓
                </option>
            </select>
        </form>
    </div>
    <div class="d-flex justify-content-start flex-wrap align-items-center gap-3">

        @foreach($pcs as $product)
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <img src="{{asset('storage/'.$product->img_path)}}" class="card-img-top" alt="Product">
                    <div class="card-body">
                        <h6 class="card-title">{{$product->name}}</h6>

                        <ul class="small lh-sm mb-3">
                        </ul>
                        <p class="card-text small text-muted">{{$product->price}} DH</p>
                        <form action="{{ route('cart.pc', $product) }}" method="POST">
                            @csrf
                            <button class="btn btn-danger w-100">
                                <i class="fa fa-cart-plus me-1"></i> Add to cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
