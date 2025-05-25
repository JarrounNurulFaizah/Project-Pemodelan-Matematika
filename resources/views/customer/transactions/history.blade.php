@extends('layouts.customer')

@section('content')
<div class="container mt-5">
    <h2 style="font-size: 24px; font-weight: bold; margin-bottom: 20px;" class="text-center">Transaction History</h2>

    
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
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-invoice:hover {
            background-color: #218838;
        }

        .btn-proof {
            background-color: #007bff;
            color: white;
            padding: 6px 10px;
            border-radius: 6px;
            text-decoration: none;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.9em;
        }
    </style>

    {{-- Tabel transaksi --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Agency Name</th>
                <th>Payment Method</th>
                <th>Payment Proof</th>
                <th>Total</th>
                <th>Status</th>
                <th>Submission Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->customer->name_institution ?? '-' }}</td>
                    <td>{{ $transaction->paymentMethod->name ?? '-' }}</td>
                    <td>
                        @if ($transaction->proof_of_payment)
                            <a href="{{ asset('storage/' . $transaction->proof_of_payment) }}" class="btn-proof" target="_blank">
                                View Proof
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td>Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}</td>
                    <td>
                        @switch(strtolower($transaction->status))
                            @case('pending')
                            @case('waiting payment')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @break
                            @case('waiting_verification')
                                <span class="badge bg-info text-dark">Waiting Verification</span>
                                @break
                            @case('completed')
                            @case('verified')
                                <span class="badge bg-success">Verified</span>
                                @break
                            @case('rejected')
                                <span class="badge bg-danger">Rejected</span>
                                @break
                            @default
                                <span class="badge bg-secondary">{{ ucfirst($transaction->status) }}</span>
                        @endswitch
                    </td>
                    <td>{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        @if (strtolower($transaction->status) === 'completed' || strtolower($transaction->status) === 'verified')
                            <a href="{{ route('customer.invoice', $transaction->id) }}" class="btn-invoice" target="_blank">
                                Cetak Invoice
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tombol kembali --}}
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('customer.home') }}" class="btn btn-secondary">Back to Home</a>
    </div>
</div>
@endsection