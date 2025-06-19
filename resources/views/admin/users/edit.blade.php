@extends('admin.layouts.app')

@section('title','Edit User')

@section('content')
    <div class="card">
        <div class="card-title"><h4>Edit User</h4></div>

        <div class="card-body w-50 mx-auto">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Email --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-md-8">
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-control">
                    </div>
                </div>

                {{-- Phone --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="phone_number" class="col-form-label">Phone Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text"
                               id="phone_number"
                               name="phone_number"
                               value="{{ old('phone_number', $user->phone_number) }}"
                               class="form-control">
                    </div>
                </div>

                {{-- Password (optional) --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="password" class="col-form-label">New Password</label>
                    </div>
                    <div class="col-md-8">
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control"
                               placeholder="Leave blank to keep existing">
                    </div>
                </div>

                {{-- Admin toggle --}}
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-4">
                        <label class="col-form-label">Admin?</label>
                    </div>
                    <div class="col-md-8">
                        <div class="form-check form-switch">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="role"
                                   name="role"
                                {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}>
                            <label class="form-check-label" for="role">Grant admin rights</label>
                        </div>
                    </div>
                </div>

                {{-- Validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-footer">
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-primary">
                            <i class="fa-solid fa-save me-2"></i>Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
