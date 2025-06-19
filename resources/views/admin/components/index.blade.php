@extends('admin.layouts.app')

@section('title','Components')

@section('content')
<a href="{{ route('admin.components.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus me-1"></i> New component</a>

<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th><th>Category</th><th>Name</th><th>Description</th><th>Price</th><th>stock</th><th>img</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    <tr>
      <td>{{ $item->id }}</td>
        <td>{{ $item->category->category }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->description }}</td>
        <td>{{ $item->price }} DH</td>
        <td>{{ $item->stock }}</td>
        <td><img src="{{asset('storage/'.$item->img_path)}}"   class="img-fluid rounded"
                 style="max-height: 180px; object-fit: cover;"></td>
      <td class="text-end">
        <a href="{{ route('admin.components.edit',$item->id) }}" class="btn btn-sm btn-light border"><i class="fa fa-pen"></i></a>
        <form action="{{ route('admin.components.destroy',$item->id) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
