@extends('layouts.customer')

@section('title', 'Checkout Details')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Transaction Details</h2>

    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    {{-- Customer Information --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Customer Information</div>
        <div class="card-body">
            <p><strong>Institution Name:</strong> {{ $customer->name_institution }}</p>
            <p><strong>Institution Email:</strong> {{ $customer->email }}</p>
            <p><strong>Transaction Number:</strong> {{ $transaction->transaction_number }}</p>
            <p><strong>Date:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
        </div>
    </div>

    {{-- Shopping Summary --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">Shopping Summary</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item['name'] ?? '-' }}</td>
                            <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-end">VAT (11%)</th>
                        <th>Rp {{ number_format($ppn, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-end">Grand Total</th>
                        <th>Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Proceed Button --}}
    <form action="{{ route('customer.checkout.confirm') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-arrow-right-circle-fill me-1"></i> Proceed to Payment Confirmation
        </button>
    </form>

    {{-- Bank Information --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">Payment Information</div>
        <div class="card-body">
            <p>Please transfer your payment to one of the following bank accounts:</p>
            <ul class="mb-0">
                <li><strong>BNI</strong> – 0301897065 a.n <strong>Mandiri Dwi Putra</strong></li>
                <li><strong>Mandiri</strong> – 4060568109 a.n <strong>Mandiri Dwi Putra</strong></li>
            </ul>
        </div>
    </div>
</div>
@endsection
