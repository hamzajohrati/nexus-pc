@extends('layouts.app')

@section('title','My Orders')

@section('content')
    <div class="container my-4">
        <h3 class="mb-3">My Orders</h3>

        {{-- flash after checkout --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-end">Total (MAD)</th>
                        <th class="text-center">Items</th>
                        <th style="width:80px"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                            <span class="badge bg-{{ $order->status == 'pending' ? 'warning' :
                                                     ($order->status == 'ready' ? 'success' : 'secondary') }}">
                                {{ ucfirst(str_replace('_',' ', $order->status)) }}
                            </span>
                            </td>
                            <td class="text-end">{{ number_format($order->total_price, 0) }}</td>
                            <td class="text-center">{{ $order->details_count }}</td>
                            <td class="text-end">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">You have not placed any orders yet.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="card-footer">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
