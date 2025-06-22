
@extends('layouts.app')
@section('title','Login')

@section('content')
<div class="container my-5">
 <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="{{asset("assets/img/login_image.png")}}" class="img-fluid rounded-3" alt="GPU">
    </div>
    <div class="col-md-6">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
      <h2 class="fw-bold mb-4">Log in to <span class="text-danger">Nexus pc</span></h2>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <div class="group">
                <input required type="text" name="email" class="input">
                <span class="highlight"></span>
                <span class="bar"></span>
                <label>Email or Phone Number</label>
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
        <div class="d-flex justify-content-between align-items-center">
          <button type="submit" class="btn btn-danger btn-lg">Log In</button>
          <a href="{{route('register')}}" class="btn btn-outline-secondary btn-lg">Or Register</a>
{{--          <a href="#" class="small text-decoration-none text-danger">Forgot Password?</a>--}}
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
