
@extends('layouts.app')
@section('title','Pre-built PCs')

@section('content')
<div class="container my-5">
  <h1 class="fw-bold mb-4">Pre-built Gaming PCs</h1>
    <div class="d-flex justify-content-between align-items-center g-4">
        @foreach($pcs as $product)
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <img src="{{asset('storage/'.$product->img_path)}}" class="card-img-top" alt="Product">
                    <div class="card-body">
                        <h6 class="card-title">{{$product->name}}</h6>
                        <p class="card-text small text-muted">{{$product->price}} DH</p>
                        <form action="{{ route('cart.pc', $product) }}" method="POST">
                            @csrf
                            <button class="btn btn-primary w-100">
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
