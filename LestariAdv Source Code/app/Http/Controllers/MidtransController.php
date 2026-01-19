<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Midtrans\Notification;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Mail\OrderPaidNotification;
use Illuminate\Support\Facades\Mail;

class MidtransController extends Controller
{
    public function handle()
    {
        // INIT CONFIG (WAJIB)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $notif = new Notification();

        Log::info('MIDTRANS WEBHOOK', (array) $notif);

        $order = Order::where('midtrans_order_id', $notif->order_id)->first();

        if (!$order) {
            Log::error('ORDER NOT FOUND', ['order_id' => $notif->order_id]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Pembayaran berhasil
        if (in_array($notif->transaction_status, ['capture', 'settlement'])) {
            $order->markAsPaid($notif->payment_type);

            // Kirim email notifikasi jika email tersedia
            if ($order->email) {
                try {
                    Mail::to($order->email)->send(new OrderPaidNotification($order));
                    Log::info('EMAIL SENT', ['order_id' => $order->id, 'email' => $order->email]);
                } catch (\Exception $e) {
                    Log::error('EMAIL FAILED', [
                        'order_id' => $order->id,
                        'email' => $order->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        // Pembayaran kadaluarsa
        if ($notif->transaction_status === 'expire') {
            $order->update([
                'payment_status' => 'expired',
                'status' => 'dibatalkan',
            ]);
        }

        return response()->json(['status' => 'ok']);
    }


    public function finish(Request $request)
    {
        return redirect()
            ->route('home')
            ->with('success', 'Terima kasih telah memesan produk LestariAdv');
    }
}
