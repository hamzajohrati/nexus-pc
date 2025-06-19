@extends('layouts.app')

@section('content')
<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1 class="h4 mb-4 text-center">Log in to Nexus PC</h1>
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" id="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" class="form-control">
                </div>
                <div class="d-grid">
                    <button class="btn btn-nexus-red">Login</button>
                </div>
            </form>
            <p class="small mt-3 text-center"><a href="{{ route('register') }}">Need an account?</a></p>
        </div>
    </div>
</section>
@endsection
