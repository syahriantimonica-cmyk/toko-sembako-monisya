<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Transaksi - {{ $transaction->kode_transaksi ?? 'Transaksi' }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #374151;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #d1d5db;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #111827;
        }

        .header p {
            margin: 4px 0;
            color: #6b7280;
        }

        .section {
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 5px;
            vertical-align: top;
        }

        .payment-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            padding: 12px;
            border-radius: 6px;
        }

        .payment-box h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #166534;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f3f4f6;
        }

        table th {
            border: 1px solid #d1d5db;
            padding: 8px;
            font-size: 11px;
            text-transform: uppercase;
        }

        table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Toko Sembako Monisya Mart</h1>
        <p>Detail Transaksi</p>
        <p>
            Dicetak:
            {{ \Carbon\Carbon::now()->format('d M Y H:i') }}
        </p>
    </div>

    <div class="section">
        <table class="info-table">
            <tr>
                <td width="50%">
                    <strong>Kode Transaksi:</strong><br>
                    {{ $transaction->kode_transaksi ?? '-' }}
                    <br><br>

                    <strong>Tanggal:</strong><br>
                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}
                    <br><br>

                    <strong>Kasir:</strong><br>
                    {{ $transaction->user->name ?? 'Admin' }}
                </td>

                <td width="50%">
                    <div class="payment-box">
                        <h3>Ringkasan Pembayaran</h3>

                        <p>
                            <strong>Total:</strong>
                            Rp {{ number_format($transaction->total ?? 0, 0, ',', '.') }}
                        </p>

                        <p>
                            <strong>Bayar:</strong>
                            Rp {{ number_format($transaction->bayar ?? 0, 0, ',', '.') }}
                        </p>

                        <p>
                            <strong>Kembalian:</strong>
                            Rp {{ number_format($transaction->kembalian ?? 0, 0, ',', '.') }}
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h3>Daftar Item</h3>

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
                @forelse($transaction->items as $item)
                    <tr>
                        <td>
                            {{ $item->product->nama ?? 'Produk Dihapus' }}
                        </td>

                        <td>
                            {{ $item->qty ?? 0 }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                        </td>

                        <td class="text-right">
                            Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Tidak ada data item
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>
            Dicetak dari Sistem Kasir Monisya Mart
        </p>
    </div>

</body>
</html>