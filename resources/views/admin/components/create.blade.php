@extends('admin.layouts.app')

@section('title','Create Component')

@section('content')
    <div class="card">
        <div class="card-title">
            <h4>New Component</h4>
        </div>

        <div class="card-body w-50 mx-auto">
            {{-- enctype for image upload --}}
            <form action="{{ route('admin.components.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                {{-- Category --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="id_category" class="col-form-label">Category</label>
                    </div>
                    <div class="col-md-6">
                        <select id="id_category" name="id_category" class="form-select">
                            <option value="" disabled selected hidden>— choose —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('id_category') == $cat->id ? 'selected' : '' }}>
                                   <i class="{{$cat->icon}} me-2"></i> {{ $cat->category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Name --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="name" class="col-form-label">Component Name</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" id="name" name="name" maxlength="100" value="{{ old('name') }}" class="form-control">
                    </div>
                </div>

                {{-- Description --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="description" class="col-form-label">Description</label>
                    </div>
                    <div class="col-md-6">
                        <textarea id="description" name="description" rows="3" maxlength="255" class="form-control">{{ old('description') }}</textarea>
                    </div>
                </div>

                {{-- Price --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="price" class="col-form-label">Price (MAD)</label>
                    </div>
                    <div class="col-md-6">
                        <input type="number" step="0.01" id="price" name="price" value="{{ old('price') }}" class="form-control">
                    </div>
                </div>

                {{-- Stock --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="stock" class="col-form-label">Stock Qty</label>
                    </div>
                    <div class="col-md-6">
                        <input type="number" id="stock" name="stock" min="0" value="{{ old('stock',0) }}" class="form-control">
                    </div>
                </div>

                {{-- Image upload --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="image" class="col-form-label">Product Image</label>
                    </div>
                    <div class="col-md-6">
                        <input class="form-control" type="file" id="image" name="image" accept="image/png,image/jpeg">
                    </div>
                </div>

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

                <div class="card-footer">
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
