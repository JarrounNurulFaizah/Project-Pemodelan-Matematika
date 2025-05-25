<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
    </style>
</head>
<body>
    <h2>INVOICE</h2>

    <p><strong>Agency:</strong> {{ $transaction->agency_name }}</p>
    <p><strong>Email:</strong> {{ $transaction->email }}</p>
    <p><strong>Transaction No:</strong> {{ $transaction->transaction_number }}</p>
    <p><strong>Date:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit</th>
                <th>Price (IDR)</th>
                <th>Amount (IDR)</th>
            </tr>
        </thead>
        <tbody>
            {{-- Asumsikan relasi product sudah di-eager load di controller --}}
            @foreach ($transaction->transactionDetails as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>Pcs</td>
                    <td>{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->price * $item->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total:</strong> Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
    <p><strong>PPN 11%:</strong> Rp {{ number_format($transaction->ppn, 0, ',', '.') }}</p>
    <p><strong>Grand Total:</strong> Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</p>

    <br><br>
    <p>Hormat Kami,</p>
    <p>(M. Sholehudin)</p>
</body>
</html>
