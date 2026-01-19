<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .order-details {
            background-color: white;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
        }

        .order-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-details td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        .order-details td:first-child {
            font-weight: bold;
            width: 40%;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            background-color: #4CAF50;
            color: white;
            border-radius: 20px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>✓ Pembayaran Berhasil!</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $order->nama_pemesan }}</strong>,</p>

            <p>Terima kasih! Pembayaran Anda telah kami terima dan pesanan Anda sedang diproses.</p>

            <div class="order-details">
                <h3>Detail Pesanan</h3>
                <table>
                    <tr>
                        <td>Kode Order</td>
                        <td><strong>{{ $order->kode_order }}</strong></td>
                    </tr>
                    <tr>
                        <td>Produk</td>
                        <td>{{ $order->nama_produk }}</td>
                    </tr>
                    <tr>
                        <td>Variasi</td>
                        <td>{{ $order->nama_variasi }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>{{ $order->qty }} pcs</td>
                    </tr>
                    <tr>
                        <td>Total Pembayaran</td>
                        <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td>Metode Pembayaran</td>
                        <td>{{ ucfirst($order->payment_method ?? 'Midtrans') }}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><span class="status-badge">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    <tr>
                        <td>Alamat Pengiriman</td>
                        <td>{{ $order->alamat }}</td>
                    </tr>
                    @if ($order->catatan_customer)
                        <tr>
                            <td>Catatan</td>
                            <td>{{ $order->catatan_customer }}</td>
                        </tr>
                    @endif
                </table>
            </div>

            <p>Pesanan Anda akan segera kami proses. Kami akan mengirimkan update status pesanan melalui email ini.</p>

            <p>Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>

            <p>Terima kasih atas kepercayaan Anda!</p>
        </div>

        <div class="footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
