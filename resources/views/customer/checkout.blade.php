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

    <form action="{{ route('customer.checkout.store') }}" method="POST" enctype="multipart/form-data">
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
                                    <img src="{{ asset('storage/' . $item->product->picture) }}" alt="{{ $item->product->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    <span>{{ $item->product->name }}</span>
                                </td>
                                <td>Rp{{ number_format($item->product->price, 0, ',', '.') }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>Rp{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</td>
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

            <!-- Metode Pembayaran -->
            <div class="mt-4">
                <label for="payment_method" class="form-label fw-bold">Choose Payment Method:</label>
                <select name="payment_method" id="payment_method" class="form-select" required>
                    <option value="" disabled selected>-- Select --</option>
                    <option value="BNI">BNI - 0301897065 (M. Sholehudin)</option>
                    <option value="BCA">BCA - 4060568109 (M. Sholehudin)</option>
                </select>
                @error('payment_method')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Upload Bukti Pembayaran -->
            <div class="mt-3">
                <label for="payment_proof" class="form-label fw-bold">Upload Payment Proof (JPG, PNG, PDF):</label>
                <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
                @error('payment_proof')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="mt-5 text-center">
                <button type="submit" class="btn btn-primary px-5">Confirm & Pay</button>
            </div>
        </div>
    </form>
</div>
@endsection
