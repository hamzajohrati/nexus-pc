@extends('admin.layouts.app')

@section('title','Dashboard')

@section('content')
<div class="d-flex justify-content-around align-items-center g-4 flex-wrap">
        <div class="card shadow-sm" style="width:18rem">
            <div class="card-body text-center">
                <h2>{{ $stats['categories'] }}</h2>
                <p class="mb-0 text-muted">Categories</p>
            </div>
        </div>
    <div class="card shadow-sm" style="width:18rem">
      <div class="card-body text-center">
        <h2>{{ $stats['components'] }}</h2>
        <p class="mb-0 text-muted">Components</p>
      </div>
    </div>
    <div class="card shadow-sm" style="width:18rem">
      <div class="card-body text-center">
        <h2>{{ $stats['pcs'] }}</h2>
        <p class="mb-0 text-muted">PCs</p>
      </div>
  </div>
    <div class="card shadow-sm" style="width:18rem">
      <div class="card-body text-center">
        <h2>{{ $stats['requests'] }}</h2>
        <p class="mb-0 text-muted">Requests</p>
      </div>
  </div>
    <div class="card shadow-sm" style="width:18rem">
      <div class="card-body text-center">
        <h2>{{ $stats['users'] }}</h2>
        <p class="mb-0 text-muted">Users</p>
      </div>
    </div>
</div>
@endsection
