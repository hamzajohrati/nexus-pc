@extends('admin.layouts.app')

@section('title','Edit Component')

@section('content')
    <div class="card">
        <div class="card-title">
            <h4>Edit Component</h4>
        </div>

        <div class="card-body w-50 mx-auto">
            <form action="{{ route('admin.components.update', $component) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Category --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="id_category" class="col-form-label">Category</label>
                    </div>
                    <div class="col-md-6">
                        <select id="id_category" name="id_category" class="form-select">
                            @foreach($categories as $cat)
                                <option
                                    value="{{ $cat->id }}"
                                    {{ old('id_category', $component->id_category) == $cat->id ? 'selected' : '' }}>
                                    <i class="{{ $cat->icon }} me-2"></i> {{ $cat->category }}
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
                        <input type="text"
                               id="name"
                               name="name"
                               maxlength="100"
                               value="{{ old('name', $component->name) }}"
                               class="form-control">
                    </div>
                </div>

                {{-- Description --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="description" class="col-form-label">Description</label>
                    </div>
                    <div class="col-md-6">
                    <textarea id="description"
                              name="description"
                              rows="3"
                              maxlength="255"
                              class="form-control">{{ old('description', $component->description) }}</textarea>
                    </div>
                </div>

                {{-- Price --}}
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-md-3">
                        <label for="price" class="col-form-label">Price (MAD)</label>
                    </div>
                    <div class="col-md-6">
                        <input type="number"
                               step="0.01"
                               id="price"
                               name="price"
                               value="{{ old('price', $component->price) }}"
                               class="form-control">
                    </div>
                </div>

                {{-- Stock --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="stock" class="col-form-label">Stock Qty</label>
                    </div>
                    <div class="col-md-6">
                        <input type="number"
                               id="stock"
                               name="stock"
                               min="0"
                               value="{{ old('stock', $component->stock) }}"
                               class="form-control">
                    </div>
                </div>

                {{-- Current image + upload new --}}
                <div class="row g-3 align-items-center mb-3">
                    <div class="col-md-3">
                        <label for="image" class="col-form-label">Product Image</label>
                    </div>
                    <div class="col-md-6">
                        @if($component->thumb_path ?? $component->img_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.($component->thumb_path ?? $component->img_path)) }}"
                                     alt="{{ $component->name }}"
                                     class="img-thumbnail"
                                     style="max-height:120px">
                            </div>
                        @endif
                        <input class="form-control"
                               type="file"
                               id="image"
                               name="image"
                               accept="image/png,image/jpeg,image/webp">
                        <small class="text-muted">Leave empty to keep existing image.</small>
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
                            <i class="fa-solid fa-save me-2"></i> Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
