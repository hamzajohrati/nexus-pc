@extends('layouts.app')   {{-- adapt to your main layout --}}

@section('title','Components')

@section('content')
    <div class="container my-4">

        {{-- ───── Filter & sort bar ───── --}}
        <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center mb-3">

            {{-- Category buttons (left) --}}
            <div class="btn-group d-flex justify-content-between flex-wrap gap-1 align-items-center">
                <a href="{{ route('components', request()->except(['cat','page'])) }}"
                   class="btn btn{{ request('cat') ? '-outline' : '' }}-danger">
                    All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('components',
                     array_merge(request()->except('page'), ['cat'=>$cat->id])) }}"
                       class="btn btn{{ request('cat') == $cat->id ? '' : '-outline' }}-danger">
                        <i class="{{ $cat->icon }} me-1"></i>{{ $cat->category }}
                    </a>
                @endforeach
            </div>

            {{-- Sort dropdown (right) --}}
            <form>
                @foreach(request()->except(['sort','page']) as $k => $v)
                    <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                @endforeach

                <select name="sort" class="form-select" onchange="this.form.submit()"
                        style="width:180px">
                    <option value="created_desc" {{ $sort=='created_desc' ? 'selected' : '' }}>
                        Newest
                    </option>
                    <option value="created_asc"  {{ $sort=='created_asc'  ? 'selected' : '' }}>
                        Oldest
                    </option>
                    <option value="price_asc"    {{ $sort=='price_asc'    ? 'selected' : '' }}>
                        Price ↑
                    </option>
                    <option value="price_desc"   {{ $sort=='price_desc'   ? 'selected' : '' }}>
                        Price ↓
                    </option>
                </select>
            </form>
        </div>
        {{-- ───── Grid of cards ───── --}}
        @if($components->count())
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 g-4">
                @foreach($components as $cmp)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if($cmp->img_path)
                                <img src="{{ asset('storage/'.$cmp->img_path) }}"
                                     class="card-img-top" alt="{{ $cmp->name }}"
                                     style="height:160px;object-fit:cover">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $cmp->name }}</h6>
                                <p class="text-muted small mb-2">
                                    {{ \Illuminate\Support\Str::limit($cmp->description, 60) }}
                                </p>

                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                <span class="fw-bold">
                                    {{ number_format($cmp->price, 0) }} MAD
                                </span>
                                <span class="">
                                 <small> Stock Actuel : {{$cmp->stock}}</small>
                                </span>
                                    <form action="{{ route('cart.component', $cmp->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger w-100">
                                            <i class="fa fa-cart-plus me-1"></i> Add to cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $components->withQueryString()->links() }}
            </div>
        @else
            <p class="text-center my-5">No components found in this category.</p>
        @endif
    </div>
    <style>
        /* Bootstrap 5 paginator → use danger colors */
        .page-link {
            color: var(--bs-danger);
        }
        .page-link:hover {
            color: #fff;
            background-color: var(--bs-danger);
            border-color: var(--bs-danger);
        }

        .page-item.active .page-link {
            color: #fff;
            background-color: var(--bs-danger);
            border-color: var(--bs-danger);
        }

        .page-item.disabled .page-link {
            color: #aaa;                       /* keep disabled grey */
        }

    </style>
@endsection
