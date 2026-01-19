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
            background-color: #2196F3;
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

        .status-update {
            background-color: white;
            padding: 20px;
            margin: 15px 0;
            border-radius: 5px;
            text-align: center;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin: 0 10px;
        }

        .status-old {
            background-color: #f0f0f0;
            color: #666;
            text-decoration: line-through;
        }

        .status-new {
            background-color: #4CAF50;
            color: white;
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

        .admin-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
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
            <h1>📦 Update Status Pesanan</h1>
        </div>

        <div class="content">
            <p>Halo <strong>{{ $order->nama_pemesan }}</strong>,</p>

            <p>Status pesanan Anda telah diupdate:</p>

            <div class="status-update">
                <p style="margin-bottom: 15px;">Status pesanan:</p>
                <span class="status-badge status-old">
                    {{ match($oldStatus) {
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'diproses' => 'Diproses',
                        'sedang_dikerjakan' => 'Sedang Dikerjakan',
                        'siap_kirim' => 'Siap Kirim',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        default => $oldStatus,
                    } }}
                </span>
                <span style="font-size: 20px;">→</span>
                <span class="status-badge status-new">
                    {{ match($order->status) {
                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                        'diproses' => 'Diproses',
                        'sedang_dikerjakan' => 'Sedang Dikerjakan',
                        'siap_kirim' => 'Siap Kirim',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                        default => $order->status,
                    } }}
                </span>
            </div>

            @if ($adminNote)
            <div class="admin-note">
                <strong>📝 Catatan dari Admin:</strong>
                <p style="margin: 10px 0 0 0;">{{ $adminNote }}</p>
            </div>
            @endif

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
                    @if ($order->nama_variasi)
                    <tr>
                        <td>Variasi</td>
                        <td>{{ $order->nama_variasi }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Jumlah</td>
                        <td>{{ $order->qty }} pcs</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                    </tr>
                </table>
            </div>

            @if ($order->status === 'dikirim')
            <p><strong>📦 Pesanan Anda sedang dalam perjalanan!</strong> Mohon ditunggu hingga paket sampai ke alamat tujuan.</p>
            @elseif ($order->status === 'selesai')
            <p><strong>✓ Terima kasih!</strong> Pesanan Anda telah selesai. Semoga Anda puas dengan produk kami!</p>
            @elseif ($order->status === 'dibatalkan')
            <p><strong>⚠️ Pesanan dibatalkan.</strong> Jika ada pertanyaan, silakan hubungi kami.</p>
            @endif

            <p>Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>
        </div>

        <div class="footer">
            <p>Email ini dikirim otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>