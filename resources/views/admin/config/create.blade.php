@extends('admin.layouts.app')

@section('title','Site Configuration')

@section('content')
    <div class="card">
        <div class="card-title">
            <h4>General Settings</h4>
        </div>

        <div class="card-body w-50 mx-auto">
            <form action="{{ route('admin.config.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="country" class="col-form-label">Country</label>
                    </div>
                    <div class="col-md-8">
                        <select id="country" name="country" class="form-select">
                            <option value="" disabled hidden>— choose —</option>
                            @foreach($countries as $c)
                                <option value="{{ $c }}" {{ old('country', $config[0]->country ?? '') == $c ? 'selected' : '' }}>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="city" class="col-form-label">City</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="city" name="city" value="{{ old('city', $config[0]->city ?? '') }}" class="form-control">
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="adresse" class="col-form-label">Address</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $config[0]->adresse ?? '') }}" class="form-control">
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-4">
                        <label for="phone" class="col-form-label">Phone Number</label>
                    </div>
                    <div class="col-md-8">
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $config[0]->phone ?? '') }}" class="form-control">
                    </div>
                </div>

                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-4">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-md-8">
                        <input type="email" id="email" name="email" value="{{ old('email', $config[0]->email ?? '') }}" class="form-control">
                    </div>
                </div>

                <h6 class="text-muted mb-2">Social Links</h6>

                @php
                    $socials = ['youtube'=>'Youtube','facebook'=>'Facebook','instagram'=>'Instagram','twitter'=>'X (Twitter)'];
                @endphp
                @foreach($socials as $field=>$label)
                    <div class="row g-3 align-items-center mb-3">
                        <div class="col-md-4">
                            <label for="{{ $field }}" class="col-form-label">{{ $label }}</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" id="{{ $field }}" name="{{ $field }}"
                                   value="{{ old($field, $config[0]->$field ?? '') }}"
                                   class="form-control">
                        </div>
                    </div>
                @endforeach

                {{-- Validation --}}
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

                @if (session('success'))
                    <div class="container mt-3">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-check me-1"></i>
                            {{ session('success') }}

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif


                <div class="card-footer">
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-save me-2"></i> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
