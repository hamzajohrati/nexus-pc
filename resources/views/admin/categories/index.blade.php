@extends('admin.layouts.app')

@section('title','Categories')

@section('content')
<a href="{{ route('admin.categories.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus me-1"></i> New category</a>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th><th>Name</th><th>Icon</th><th>Color</th><th>Description</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    <tr>
        <td>{{ $item->id }}</td>
        <td>{{ $item->category }}</td>
        <td>
            <i class="{{$item->icon}} fa-2x"></i>
        </td>
        <td><span
                style="display:inline-block;
                               width:28px;height:28px;
                               border-radius:4px;
                               background: {{ $item->color }};">
                    </span>
        </td>
        <td>{{ $item->description }}</td>
        <td class="text-end">
            <a href="{{ route('admin.categories.edit',$item->id) }}" class="btn btn-sm btn-light border"><i class="fa fa-pen"></i></a>
            <form action="{{ route('admin.categories.destroy',$item->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
