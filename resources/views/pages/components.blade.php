
@extends('layouts.app')
@section('title','Components')

@section('content')
<div class="container my-5">
  <h1 class="fw-bold mb-4">Components</h1>
  <div class="row g-4">
    @foreach(range(1,12) as $i)
    @php
        $name = 'Component '.$i;
        $price = 49 + $i*10;
    @endphp
    <div class="col-6 col-md-3">
      <div class="card h-100 shadow-sm">
        <img src="https://source.unsplash.com/random/400x300?component,{{ $i }}" class="card-img-top" alt="{{ $name }}">
        <div class="card-body d-flex flex-column">
          <h6 class="card-title">{{ $name }}</h6>
          <p class="small text-muted mb-3">$ {{ $price }}</p>
          <button class="btn btn-sm btn-nexus-red mt-auto addToCart"
                  data-id="c{{ $i }}" data-name="{{ $name }}" data-price="{{ $price }}">
            <i class="fa fa-cart-plus me-1"></i> Add to cart
          </button>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection
