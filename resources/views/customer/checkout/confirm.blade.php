@extends('layouts.customer')

@section('title', 'Payment Confirmation')

@section('content')
<div class="container py-5 d-flex justify-content-center">
    <div class="col-md-8">

        <h2 class="mb-4 text-center">Payment Confirmation</h2>

        {{-- Transaction Information --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white">Transaction Information</div>
            <div class="card-body">
                <p><strong>Transaction Number:</strong> {{ $transaction->transaction_number ?? '-' }}</p>
                <p><strong>Total Payment:</strong> Rp {{ number_format($transaction->grand_total ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Product Details --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white">Product Details</div>
            <div class="card-body p-0">
                <table class="table mb-0 table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaction->details ?? [] as $detail)
                            <tr>
                                <td>{{ $detail->product->name ?? $detail->item_name ?? '-' }}</td>
                                <td>{{ $detail->quantity ?? 0 }}</td>
                                <td>Rp {{ number_format($detail->price ?? 0, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No product details available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Payment Confirmation Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">Upload Payment Proof</div>
            <div class="card-body">
                <form action="{{ route('customer.checkout.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Hidden Transaction ID --}}
                    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

                    {{-- Institution Name --}}
                    <div class="mb-3">
                        <label for="name_institution" class="form-label">Institution Name</label>
                        <input type="text" name="name_institution" id="name_institution"
                            value="{{ old('name_institution', $transaction->institution_name ?? auth('customer')->user()->name_institution ?? '') }}"
                            class="form-control @error('name_institution') is-invalid @enderror" required>
                        @error('name_institution')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Method --}}
                    <div class="mb-3">
                        <label for="payment_method_id" class="form-label">Payment Method</label>
                        <select name="payment_method_id" id="payment_method_id"
                            class="form-select @error('payment_method_id') is-invalid @enderror" required>
                            <option value="">-- Select Method --</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}"
                                    {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                    {{ strtoupper($method->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('payment_method_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Payment Proof Upload --}}
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Payment Proof</label>
                        <input type="file" name="payment_proof" id="payment_proof"
                            class="form-control @error('payment_proof') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png" aria-describedby="paymentProofHelp" required>
                        <div id="paymentProofHelp" class="form-text">Allowed types: JPG, JPEG, PNG — Max: 5MB</div>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-1"></i> Submit Confirmation
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Payment Instructions --}}
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
</div>
@endsection
