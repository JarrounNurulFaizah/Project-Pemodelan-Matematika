@extends('layouts.customer')

@section('title', 'Checkout Details')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">Transaction Details</h2>

    {{-- Notifications --}}
    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Customer Information --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">Customer Information</div>
        <div class="card-body">
            <p><strong>Institution Name:</strong> {{ e(auth('customer')->user()->name_institution ?? '-') }}</p>
            <p><strong>Institution Email:</strong> {{ e(auth('customer')->user()->email ?? '-') }}</p>
            <p><strong>Transaction Number:</strong> {{ $transaction->transaction_number ?? '-' }}</p>
            <p><strong>Date:</strong> {{ optional($transaction->created_at)->format('F j Y ; g:i A') ?? '-' }}</p>
        </div>
    </div>

    {{-- Purchase Summary --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-secondary text-white">Purchase Summary</div>
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th class="text-start">Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->details ?? [] as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-start">{{ $detail->item_name ?? '-' }}</td>
                            <td>Rp {{ number_format($detail->price ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $detail->quantity ?? 0 }}</td>
                            <td>Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                @php
                    $total = $transaction->total ?? 0;
                    $ppn = $transaction->ppn ?? round($total * 0.11);
                    $grandTotal = $transaction->grand_total ?? ($total + $ppn);
                @endphp
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total</th>
                        <th>Rp {{ number_format($total, 0, ',', '.') }}</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-end">Tax (PPN 11%)</th>
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

    {{-- Action Buttons --}}
    <div class="mb-3">
        @if(isset($transaction->id) && !empty($transaction->transaction_number))
            <a href="{{ route('customer.checkout.confirm', $transaction->id) }}" class="btn btn-success w-100">
                <i class="bi bi-cash-coin me-1"></i> Proceed to Payment Confirmation
            </a>
        @else
            <p class="text-center text-muted">Transaction is not yet finalized. Please complete your purchase first.</p>
        @endif
    </div>

    {{-- Payment Info --}}
    <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">Payment Information</div>
        <div class="card-body">
            <p>Please transfer your payment to one of the following accounts:</p>
            <ul class="mb-0">
                <li><strong>BNI</strong> – 0301897065 a.n <strong>Mandiri Dwi Putra</strong></li>
                <li><strong>Mandiri</strong> – 4060568109 a.n <strong>Mandiri Dwi Putra</strong></li>
            </ul>
        </div>
    </div>
</div>
@endsection
