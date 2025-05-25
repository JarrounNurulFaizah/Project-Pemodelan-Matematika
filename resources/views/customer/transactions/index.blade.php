@extends('layouts.customer') {{-- Sesuaikan kalau layoutmu beda --}}

@section('content')
<div class="container mt-5">
    <h2>Transaction History</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->created_at->format('d M Y') }}</td>
                    <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td><span class="text-success">Paid</span></td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
