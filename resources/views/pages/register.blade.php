
@extends('layouts.app')
@section('title','Register')

@section('content')
<div class="container my-5">
 <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="{{ asset('assets/img/login_image.png')}}" class="img-fluid rounded-3" alt="GPU">
    </div>
    <div class="col-md-6">
        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <h5 class="mb-2">Whoops! Something went wrong…</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
      <h2 class="fw-bold mb-4">Create an account</h2>
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <div class="group">
                <input required type="text" name="email" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Email</label>
            </div>
        </div>
          <div class="mb-3">
              <div class="group">
                  <input required type="text" name="phone_number" class="input">
                  <span class="highlight"></span>
                  <span class="bar"></span>
                  <label>Phone number (+212xxxxxxxxx)</label>
              </div>
          </div>
        <div class="mb-3">
            <div class="group">
                <input required type="password" name="password" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Password</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="group">
                <input required type="password" name="password_confirmation" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Confirm Password</label>
            </div>
        </div>
        <button class="btn btn-nexus-red">Register</button>
      </form>
    </div>
  </div>
</div>
@endsection
