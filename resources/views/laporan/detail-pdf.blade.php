<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Transaksi - {{ $transaction->kode_transaksi }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #374151;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            color: #111827;
        }
        .header p {
            margin: 5px 0;
            color: #6b7280;
        }
        .info {
            margin-bottom: 20px;
            display: table;
            width: 100%;
        }
        .info-left, .info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .info-left {
            padding-right: 20px;
        }
        .info p {
            margin: 3px 0;
        }
        .payment-summary {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .payment-summary h3 {
            margin: 0 0 10px 0;
            color: #166534;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            font-weight: bold;
            font-size: 11px;
            color: #374151;
            text-transform: uppercase;
        }
        td {
            font-size: 11px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Toko Sembako Monisya Mart</h1>
        <p>Detail Transaksi</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
    </div>

    <div class="info">
        <div class="info-left">
            <p><strong>Kode Transaksi:</strong> {{ $transaction->kode_transaksi }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}</p>
            <p><strong>Kasir:</strong> {{ $transaction->user->name }}</p>
        </div>
        <div class="info-right">
            <div class="payment-summary">
                <h3>Ringkasan Pembayaran</h3>
                <p><strong>Total:</strong> Rp {{ number_format($transaction->total, 0, ',', '.') }}</p>
                <p><strong>Bayar:</strong> Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</p>
                <p><strong>Kembalian:</strong> Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <h3 style="margin-bottom: 10px; color: #111827;">Daftar Item</h3>
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $item)
            <tr>
                <td>{{ $item->product->nama }}</td>
                <td>{{ $item->qty }}</td>
                <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak dari Sistem Toko Sembako Monisya Mart</p>
    </div>
</body>
</html>