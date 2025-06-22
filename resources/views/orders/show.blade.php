@extends('layouts.app')

@section('title','Order #'.$order->id)

@section('content')
    <div class="container my-4">
        {{-- flash after checkout --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-1"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        <h3 class="mb-4">Order&nbsp;#{{ $order->id }}</h3>

        {{-- meta bar --}}
        <div class="row mb-4">
            <div class="col-md-3"><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</div>
            <div class="col-md-3"><strong>Status:</strong>
                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' :
                                     ($order->status == 'ready'   ? 'success' : 'secondary') }}">
               {{ ucfirst(str_replace('_',' ', $order->status)) }}
            </span>
            </div>
            <div class="col-md-3"><strong>Total:</strong> {{ number_format($order->total_price,0) }} MAD</div>
        </div>

        {{-- line items --}}
        <table class="table align-middle">
            <thead class="table-light">
            <tr>
                <th>img</th>
                <th>Description</th>
                <th class="text-end">Price</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->details as $d)
                @php
                    $img_path  = $d->component?->img_path ?? $d->pc?->img_path ?? '—';
                    $name  = $d->component?->name ?? $d->pc?->name ?? '—';
                    $price = $d->component?->price ?? $d->pc?->price ?? 0;
                @endphp
                <tr>
                    <td><img src="{{asset('storage/'.$img_path)}}" alt="" srcset="" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;"> </td>
                    <td>{{ $name }}</td>
                    <td class="text-end">{{ number_format($price,0) }}</td>
                    <td class="text-center">{{ $d->quantity }}</td>
                    <td class="text-end">{{ number_format($price * $d->quantity,0) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot class="table-light">
            <tr>
                <th colspan="3" class="text-end">Grand total</th>
                <th class="text-end">{{ number_format($order->total_price,0) }} MAD</th>
            </tr>
            </tfoot>
        </table>

        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary mt-3">
            ← Back to My Orders
        </a>
    </div>
@endsection
