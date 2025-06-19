@extends('admin.layouts.app')

@section('title','Add User')

@section('content')
    <div class="card">
        <div class="card-title"><h4>New User</h4></div>

        <div class="card-body w-50 mx-auto">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4"><label for="email" class="col-form-label">Email</label></div>
                    <div class="col-md-8">
                        <input type="email" id="email" name="email"
                               value="{{ old('email') }}" class="form-control">
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4"><label for="phone_number" class="col-form-label">Phone Number</label></div>
                    <div class="col-md-8">
                        <input type="text" id="phone_number" name="phone_number" class="form-control">
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4"><label for="password" class="col-form-label">Password</label></div>
                    <div class="col-md-8">
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-4"><label class="col-form-label">Admin?</label></div>
                    <div class="col-md-8">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   id="role" name="role"
                                {{ old('role') ==='admin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_admin">Grant admin rights</label>
                        </div>
                    </div>
                </div>

                {{-- Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i>Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
