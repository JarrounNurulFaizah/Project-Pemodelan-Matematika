@extends('layouts.customer')

@section('content')
<style>
    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    th {
        background-color: #004080;
        color: white;
        padding: 12px;
        text-align: left;
        border-radius: 8px 8px 0 0;
    }

    td {
        background-color: #f9f9f9;
        padding: 12px;
        border-bottom: 1px solid #ddd;
        border-radius: 4px;
    }

    tr:hover td {
        background-color: #f1f1f1;
    }

    .btn-invoice {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 10px;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn-invoice:hover {
        background-color: #c82333;
    }

    .summary-table td {
        border: none !important;
        background: none !important;
        padding: 6px 0;
    }

    .summary-table {
        margin-top: 20px;
        font-weight: bold;
    }

    .container-cart {
        padding: 40px;
    }

    .btn-back {
        background-color: #6c757d;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
    }

    .btn-checkout {
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        border: none;
    }

    .btn-checkout:hover {
        background-color: #218838;
    }

    .text-center {
        text-align: center;
    }
</style>

<div class="container-cart">
    <h2 class="text-center mb-4">Cart List</h2>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Sub-Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; $total = 0; @endphp

                @forelse ($cart as $id => $item)
                    @php 
                        $subTotal = $item['price'] * $item['quantity'];
                        $total += $subTotal;
                    @endphp
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp{{ number_format($subTotal, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('customer.cart.remove', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-invoice">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Your cart is currently empty.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row justify-content-end mt-4">
        <div class="col-md-4 offset-md-8">
            @php $ppn = $total * 0.11; $grandTotal = $total + $ppn; @endphp
            <table class="summary-table">
                <tr>
                    <td>Total:</td>
                    <td class="text-end">Rp{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>PPN (11%):</td>
                    <td class="text-end">Rp{{ number_format($ppn, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Grand Total:</td>
                    <td class="text-end">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('customer.home') }}" class="btn-back">Back to Home</a>

        @if ($total > 0)
            <form action="{{ route('customer.checkout.confirm') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-checkout">Checkout</button>
            </form>
        @endif
    </div>
</div>
@endsection
