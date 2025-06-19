
@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="hero text-white d-flex align-items-center">
  <div class="hero-overlay"></div>
  <div class="container position-relative">
    <h1 class="display-4 fw-bold"><strong class="text-nexus-red">Power</strong> Your Digital Experience</h1>
    <p class="lead">Build your dream PC or pick a battle‑tested pre‑build.</p>
    <a href="{{ route('builder') }}" class="btn btn-nexus-red me-2">Build Your Own PC</a>
    <a href="{{ route('prebuilt') }}" class="btn btn-outline-light">Shop Pre‑built PCs</a>
  </div>
</div>


<div class="container my-5">
  <h2 class="fw-bold mb-4">Featured Products</h2>
  <div class="row g-4">
    @foreach($featuredProducts as $product)
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

<div class="bg-light py-5">
  <div class="container">
    <h2 class="fw-bold text-center mb-4">Shop by Category</h2>
    <h4 class=" text-center mb-4">Explore our wide range of PC components and pre-built systems to find exactly what you need.</h4>
    <div class="row text-center g-4">
        <div class="d-flex flex-row flex-wrap justify-content-around align-items-center">
            <div class="card mt-3 rounded" style="width: 18rem;  background-color: #FFFBFB">
                <div class="card-body">
                    <div class="d-flex flex-column flex-wrap justify-content-start align-items-center">
                        <i class="fa-solid fa-desktop fa-2x mb-2 me-auto text-white" style="background-color: #0059FF; padding: 5% ;border-radius: 50%"></i>
                        <div class="me-auto">Pre-built PCs</div>
                        <small class="me-auto">Ready-to-use systems built and tested by experts</small>
                    </div>
                </div>
            </div>
      @foreach($categories as $cat)
          <div class="card mt-3 rounded" style="width: 18rem; background-color: #FFFBFB">
              <div class="card-body">
                  <div class="d-flex flex-column flex-wrap justify-content-start align-items-center">
                      <i class="{{$cat->icon}} fa-2x mb-2 me-auto text-white" style="background-color: {{$cat->color}}; padding: 5% ;border-radius: 50%"></i>
                      <div class="me-auto">{{ $cat->category }}</div>
                      <small class="me-auto">{{ $cat->description }}</small>
                  </div>
              </div>
          </div>
      @endforeach
        </div>
    </div>
  </div>
</div>

<div class="container my-5">
  <h2 class="fw-bold text-center mb-4">Ready to Build Your Dream PC?</h2>
  <div class="text-center">
    <a href="{{ route('builder') }}" class="btn btn-nexus-red btn-lg">Start Building</a>
  </div>
</div>
@endsection
