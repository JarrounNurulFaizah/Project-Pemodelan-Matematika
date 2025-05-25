@extends('layouts.customer')

@section('title', 'Daftar Transaksi')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Daftar Transaksi Anda</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($transactions->isEmpty())
        <div class="alert alert-info">
            Belum ada transaksi yang tercatat.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nomor Transaksi</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Metode</th>
                        <th>Bukti Bayar</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $index => $transaction)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $transaction->transaction_number }}</td>
                            <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge 
                                    @if($transaction->status == 'pending') bg-warning text-dark
                                    @elseif($transaction->status == 'waiting_verification') bg-info
                                    @elseif($transaction->status == 'paid') bg-success
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td>{{ optional($transaction->paymentMethod)->name ?? '-' }}</td>
                            <td>
                                @if($transaction->proof_of_payment)
                                    <a href="{{ asset('storage/' . $transaction->proof_of_payment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Lihat Bukti
                                    </a>
                                @else
                                    <span class="text-muted">Belum Upload</span>
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
