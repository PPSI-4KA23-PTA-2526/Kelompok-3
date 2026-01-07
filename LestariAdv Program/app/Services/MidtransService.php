<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Order;

class MidtransService
{
    public static function init(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public static function createSnap(Order $order): string
    {
        self::init();

        $params = [
            'transaction_details' => [
                'order_id' => $order->midtrans_order_id,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->nama_pemesan,
                'email' => $order->email,
                'phone' => $order->no_hp,
            ],
            'item_details' => [
                [
                    'id' => $order->product_variant_id,
                    'price' => (int) $order->harga,
                    'quantity' => $order->qty,
                    'name' => $order->nama_produk . ' - ' . $order->nama_variasi,
                ]
            ]
        ];

        return Snap::getSnapToken($params);
    }
}
