@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h3>Your Cart</h3>

        @if(!$cart->countLines())
            <p>Nothing yet.</p>
        @else
            <table class="table">
                @foreach($cart->items() as $row)
                    <tr>
                        <td style="width: 150px;"><img src="{{ asset('storage/'.($row['img_path'] ?? '')) }}" alt="" class="img-fluid rounded" style="max-height: 150px; object-fit: cover;"></td>
                        <td style="padding-top: 50px;><span ">{{ $row['name'] }}</span></td>
                        <td class="text-end">{{ $row['qty'] }} × {{ number_format($row['price'],0) }} DH</td>
                        <td class="text-end">
                            <form action="{{ route('cart.remove',$row['rowId']) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">&times;</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr class="table-light">
                    <th>Total</th>
                    <th class="text-end">{{ number_format($cart->total(),0) }} DH</th>
                    <th></th>
                </tr>
            </table>

            <form action="{{ route('checkout') }}" method="POST" class="text-end">
                @csrf
                <button class="btn btn-primary">Checkout</button>
            </form>
        @endif
    </div>
@endsection
