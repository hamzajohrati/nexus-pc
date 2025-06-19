
@extends('layouts.app')
@section('title','PC Builder')

@section('content')
<div class="container my-5">
  <h1 class="fw-bold mb-4">Custom PC Builder</h1>
  <div class="row g-4">
    @php $parts=['Processor','Motherboard','GPU','RAM','Storage','Case','PSU','Cooler']; @endphp
    @foreach($parts as $part)
      <div class="col-6 col-md-3">
        <div class="border rounded-3 p-4 text-center position-relative">
          <i class="fa-solid fa-plus fa-2x mb-2 text-muted"></i>
          <div>{{ $part }}</div>
          <small class="text-muted">Select {{ $part }}</small>
        </div>
      </div>
    @endforeach
  </div>
  <div class="text-end mt-4">
    <button class="btn btn-nexus-red addToCart" data-id="build1" data-name="Custom Build" data-price="0">Add Build to Cart</button>
  </div>
</div>
@endsection
