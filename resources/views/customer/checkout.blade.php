@extends('layouts.customer')

@section('content')
<!-- Tambahkan Font EB Garamond -->
<link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    body {
        font-family: 'EB Garamond', serif;
    }
</style>

<div class="container mt-5">
    <h2 class="fw-bold mb-4 text-center">Transaction Details</h2>

    <form action="{{ route('customer.checkout.store') }}" method="POST">
        @csrf

        <div class="card p-4 shadow-sm">
            <!-- Informasi Agen dan Transaksi -->
            <div class="mb-4">
                <p><strong>Agency Name:</strong> {{ auth()->guard('customer')->user()->name_institution ?? '-' }}</p>
                <p><strong>Agency Email:</strong> {{ auth()->guard('customer')->user()->email }}</p>
                <p><strong>Telepon:</strong> {{ auth()->guard('customer')->user()->phone ?? '-' }}</p>
                <p><strong>Transaction Number:</strong> TRX{{ now()->format('YmdHis') }}</p>
                <p><strong>Date:</strong> {{ now()->format('d-m-Y') }}</p>
            </div>

            <!-- Tabel Produk -->
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    <span>{{ $item['name'] }}</span>
                                </td>
                                <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td>{{ $item['quantity'] }}</td>
                                <td>Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total</td>
                            <td class="fw-bold">Rp{{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">PPN (11%)</td>
                            <td class="fw-bold">Rp{{ number_format($ppn, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Grand Total</td>
                            <td class="fw-bold">Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Tombol Submit -->
            <div class="mt-5 text-center">
                <button type="submit" class="btn btn-primary px-5">Proceed to Payment Confirmation</button>
            </div>
        </div>
    </form>
</div>
@endsection
