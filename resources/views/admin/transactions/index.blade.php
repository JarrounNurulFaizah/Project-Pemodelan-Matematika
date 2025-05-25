@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4" style="font-size: 24px; font-weight: bold;">Transaction List</h2>

    <style>
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        th {
            background-color: #003366;
            color: white;
            padding: 12px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }

        td {
            background-color: #ffffff;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            border-radius: 4px;
        }

        tr:hover td {
            background-color: #f1f1f1;
        }

        .btn-sm {
            font-size: 0.85rem;
            padding: 5px 10px;
            border-radius: 6px;
        }

        .btn-outline-primary {
            color: #007bff;
            border: 1px solid #007bff;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.9em;
            color: white;
        }

        .text-muted {
            color: #6c757d;
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Institution</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Proof</th>
                    <th>Action</th>
                    <th>Delivery</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $transaction->customer->name_institution ?? '-' }}</td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>Rp{{ number_format($transaction->total, 0, ',', '.') }}</td>
                        <td>{{ $transaction->paymentMethod->name ?? '-' }}</td>
                        <td>
                            @switch($transaction->status)
                                @case('waiting_verification')
                                    <span class="badge bg-warning text-dark">Waiting</span>
                                    @break
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
                        <td>
                            @if ($transaction->proof_of_payment)
                                <a href="{{ asset('storage/' . $transaction->proof_of_payment) }}" target="_blank" class="btn btn-outline-primary btn-sm">View</a>
                            @else
                                <span class="text-muted">No file</span>
                            @endif
                        </td>
                        <td>
                            @if ($transaction->status === 'waiting_verification')
                                <form action="{{ route('admin.transactions.verify', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Verify</button>
                                </form>
                                <form action="{{ route('admin.transactions.reject', $transaction->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to reject this transaction?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            @else
                                <span class="text-muted">No action</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.transactions.delivery-order.download', $transaction->id) }}" target="_blank" class="btn btn-outline-primary btn-sm">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">No transactions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
