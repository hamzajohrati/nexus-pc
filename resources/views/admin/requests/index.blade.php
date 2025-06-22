@extends('admin.layouts.app')

@section('title','Requests')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Customer Requests</h4>
    </div>

    {{-- flash --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Date</th>
                    <th class="text-end">Total</th>
                    <th class="text-center">Items</th>
                    <th>Status</th>
                    <th style="width:170px"></th>
                </tr>
                </thead>
                <tbody>
                @forelse($orders as $o)
                    <tr>
                        <td>{{ $o->id }}</td>
                        <td>{{ $o->user->email ?? '—' }}</td>
                        <td>{{ $o->created_at->format('Y-m-d H:i') }}</td>
                        <td class="text-end">{{ number_format($o->total_price,0) }} MAD</td>
                        <td>
                            @foreach($o->details as $det)
                                @php
                                    $model = $det->component ?: $det->pc;      // whichever exists
                                @endphp
                                <div>{{ $model->id }} – {{ $model->name }}
                                    <span class="badge bg-secondary ms-1">× {{ $det->quantity }}</span></div>
                            @endforeach
                        </td>
                        <td>
                        <span class="badge bg-{{ [
                            'pending'     => 'warning',
                            'in_progress' => 'info',
                            'ready'       => 'success',
                            'shipped'     => 'primary',
                            'delivered'   => 'secondary'
                        ][$o->status] }}">
                            {{ ucfirst(str_replace('_',' ', $o->status)) }}
                        </span>
                        </td>
                        <td class="text-end">
                            {{-- status form --}}
                            <form class="d-inline" method="POST"
                                  action="{{ route('admin.requests.update', $o) }}">
                                @csrf @method('PUT')
                                <select name="status" class="form-select form-select-sm d-inline w-auto">
                                    @foreach($statuses as $st)
                                        <option value="{{ $st }}" {{ $o->status==$st?'selected':'' }}>
                                            {{ ucfirst(str_replace('_',' ',$st)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-sm btn-outline-primary mt-2">Update</button>
                            </form>

                            {{-- delete --}}
                            <form class="d-inline" method="POST"
                                  action="{{ route('admin.requests.destroy', $o) }}"
                                  onsubmit="return confirm('Delete request #{{ $o->id }}?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger mt-2">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center py-4">No requests yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="card-footer">{{ $orders->links() }}</div>
        @endif
    </div>
@endsection
