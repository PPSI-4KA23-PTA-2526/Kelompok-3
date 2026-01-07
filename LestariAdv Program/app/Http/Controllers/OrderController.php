<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\MidtransService;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'nama_pemesan' => 'required|string',
            'no_hp' => 'required|string',
            'email' => 'nullable|email',
            'alamat' => 'required|string',
        ]);

        $variant = ProductVariant::findOrFail($request->product_variant_id);

        $prices = $variant->price_data;
        $index = $request->price_index ?? 0;

        if (!is_array($prices) || !isset($prices[$index])) {
            return response()->json(['message' => 'Harga tidak valid'], 422);
        }

        $price = $prices[$index];

        $filePath = null;
        if ($request->hasFile('file_desain')) {
            $filePath = $request->file('file_desain')->store('orders', 'public');
        }

        $order = Order::create([
            'product_id' => $variant->product_id,
            'product_variant_id' => $variant->id,
            'nama_produk' => $variant->product->nama_produk,
            'nama_variasi' => $variant->nama_variasi,
            'qty' => 1,
            'harga' => $price['harga'],
            'total' => $price['harga'],
            'price_option' => $price,

            'nama_pemesan' => $request->nama_pemesan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'alamat' => $request->alamat,
            'catatan_customer' => $request->catatan_customer,
            'file_desain' => $filePath,

            'kode_order' => 'ORD-' . uniqid(),
            'midtrans_order_id' => 'MID-' . uniqid(),
        ]);

        try {
            $snapToken = MidtransService::createSnap($order);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Midtrans error',
                'error' => $e->getMessage()
            ], 500);
        }

        $order->update(['snap_token' => $snapToken]);

        return response()->json(['snap_token' => $snapToken]);
    }
}
