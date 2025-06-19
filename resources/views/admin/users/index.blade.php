@extends('admin.layouts.app')

@section('title','Users')

@section('content')
<a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3"><i class="fa fa-plus me-1"></i> New user</a>
<table class="table table-hover">
  <thead>
    <tr>
      <th>ID</th><th>Email</th><th>Role</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($items as $item)
    <tr>
      <td>{{ $item->id }}</td><td>{{ $item->email }}</td><td>{{ $item->role }}</td>
      <td class="text-end">
{{--        <a href="{{ route('admin.users.edit',$item->id) }}" class="btn btn-sm btn-light border"><i class="fa fa-pen"></i></a>--}}
        <form action="{{ route('admin.users.destroy',$item->id) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection
