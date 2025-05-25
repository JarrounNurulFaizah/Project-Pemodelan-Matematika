<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>DELIVERY ORDER #{{ $transaction->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 20px;
            color: #000;
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
            margin-right: 15px;
        }
        .company-info {
            font-weight: bold;
            line-height: 1.2;
        }
        .invoice-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin: 20px 0 10px;
        }
        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }
        table.invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }
        table.invoice-table th, table.invoice-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .note {
            margin-top: 15px;
            font-size: 12px;
            font-style: italic;
        }
        .signature-block {
            margin-top: 40px;
            text-align: right;
        }
        .signature-block p {
            margin: 0;
        }
        .signature-block img {
            height: 80px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('images/logo-mandiri.jpg') }}" alt="Logo CV Mandiri Dwi Putra" />
        <div class="company-info">
            CV. MANDIRI DWI PUTRA<br />
            GENERAL SUPPLIER & MANUFACTURER<br />
            Telp./Fax (021) 82498725
        </div>
    </div>

    <table class="info-table" style="width: 100%; margin-bottom: 10px;">
        <tr>
            <td style="width: 50%;">
                <strong>To:</strong><br />
                {{ $transaction->customer->name_institution ?? '-' }}<br />
                {{ $transaction->customer->address ?? '-' }}
            </td>
            <td>
                <table>
                    <tr><td>No</td><td>: {{ $transaction->id }}</td></tr>
                    <tr><td>Date</td><td>: {{ $transaction->created_at->format('d-m-Y') }}</td></tr>
                    <tr><td>Payment Method</td><td>: {{ $transaction->paymentMethod->name ?? '-' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="invoice-title">DELIVERY ORDER</div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 55%;">Description</th>
                <th style="width: 10%;">Qty</th>
                <th style="width: 15%;">Price (IDR)</th>
                <th style="width: 15%;">Amount (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp

            @foreach($transaction->transactionDetails as $index => $item)
                @php
                    $subtotal = $item->quantity * $item->price;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->name ?? $item->item_name }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="4" class="text-right"><strong>Total</strong></td>
                <td class="text-right"><strong>Rp{{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
            @php
                $ppn = $total * 0.11;
                $grandTotal = $total + $ppn;
            @endphp
            <tr>
                <td colspan="4" class="text-right">PPN 11%</td>
                <td class="text-right">Rp{{ number_format($ppn, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Grand Total</strong></td>
                <td class="text-right"><strong>Rp{{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 15px;">
        <strong>Terbilang:</strong> {{ ucwords(terbilang($grandTotal)) }} rupiah
    </div>

    <div class="note">
        <strong>Note:</strong><br />
        - Barang yang sudah dibeli tidak dapat dikembalikan.
    </div>

    <div class="signature-block">
        <p>Hormat Kami,</p>
        <img src="{{ public_path('images/logo-delivery.jpg') }}" alt="Stempel">
        <p><strong>(M. Sholehudin)</strong></p>
    </div>

</body>
</html>
