<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi - Toko Sembako</title>
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
        }
        .info p {
            margin: 3px 0;
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
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #e5e7eb;
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
        <h1>Toko Sembako </h1>
        <p>Laporan Transaksi</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
    </div>

    <div class="info">
        <p><strong>Total Transaksi:</strong> {{ $transactions->count() }}</p>
        <p><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>

    @if($transactions->count() > 0)
    <table>
        <thead>
            <tr>
                <th>Kode Transaksi</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Jumlah Item</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->kode_transaksi }}</td>
                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $transaction->user->name }}</td>
                <td>{{ $transaction->items->sum('qty') }}</td>
                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p style="text-align: center; padding: 40px; color: #6b7280;">Belum ada data transaksi</p>
    @endif

    <div class="footer">
        <p>Dicetak dari Sistem Toko Sembako </p>
    </div>
</body>
</html>