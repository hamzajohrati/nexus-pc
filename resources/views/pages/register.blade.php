
@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="container my-5">
 <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="https://images.unsplash.com/photo-1587202372775-98954bc22c1b?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-3" alt="GPU">
    </div>
    <div class="col-md-6">
      <h2 class="fw-bold mb-4">Create an account</h2>
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-nexus-red">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
