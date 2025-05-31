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
        vertical-align: middle;
    }

    tr:hover td {
        background-color: #f1f1f1;
    }

    .btn-invoice {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-invoice:hover {
        background-color: #c82333;
    }

    .summary-table td {
        border: none !important;
        background: none !important;
        padding: 6px 0;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .summary-table {
        margin-top: 20px;
        font-weight: bold;
    }

    .container-cart {
        padding: 40px 20px;
        max-width: 900px;
        margin: auto;
    }

    .btn-back {
        background-color: #6c757d;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        margin-right: 10px;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #5a6268;
    }

    .btn-checkout {
        background-color: #28a745;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-checkout:hover {
        background-color: #218838;
    }

    .text-center {
        text-align: center;
    }

    /* Responsive for smaller screens */
    @media (max-width: 576px) {
        td, th {
            font-size: 0.9rem;
            padding: 8px;
        }
        .btn-invoice, .btn-back, .btn-checkout {
            padding: 6px 10px;
            font-size: 0.9rem;
        }
        .container-cart {
            padding: 20px 10px;
        }
    }
</style>

<div class="container-cart">
    <h2 class="text-center mb-4">Cart List</h2>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th style="width:40%;">Product Name</th>
                    <th style="width:15%;">Price</th>
                    <th style="width:10%;">Quantity</th>
                    <th style="width:20%;">Sub-Total</th>
                    <th style="width:10%;">Action</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $i = 1; 
                    $total = 0; 
                @endphp

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
                                <button type="submit" class="btn-invoice" onclick="return confirm('Are you sure to remove this product?')">Remove</button>
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

    @if($total > 0)
        <div class="row justify-content-end mt-4">
            <div class="col-md-4 offset-md-8">
                @php 
                    $ppn = $total * 0.11; 
                    $grandTotal = $total + $ppn; 
                @endphp
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
    @endif

    <div class="text-center mt-4">
        <a href="{{ route('customer.home') }}" class="btn-back">Back to Home</a>

        @if ($total > 0)
            {{-- Ganti route checkout.detail yang butuh id, ke route store checkout atau form checkout --}}
            <form action="{{ route('customer.checkout.store') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn-checkout">Checkout</button>
            </form>
        @endif
    </div>
</div>
@endsection