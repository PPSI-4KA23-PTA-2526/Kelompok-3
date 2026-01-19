<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductVariant;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'product_variant_id' => 'required|exists:product_variants,id',
                'quantity' => 'required|integer|min:1',
                'nama_pemesan' => 'required|string',
                'no_hp' => 'required|string',
                'email' => 'nullable|email',
                'alamat' => 'required|string',
            ]);

            $variant = ProductVariant::findOrFail($request->product_variant_id);

            $price = $variant->price_data[$request->price_index ?? 0];

            // Ambil quantity dari request
            $quantity = $request->quantity;

            // Hitung total berdasarkan harga * quantity
            $hargaSatuan = $price['harga'];
            $totalHarga = $hargaSatuan * $quantity;

            $filePath = $request->hasFile('file_desain')
                ? $request->file('file_desain')->store('orders', 'public')
                : null;

            $kodeOrder = 'ORD-' . uniqid();

            $order = Order::create([
                'product_id' => $variant->product_id,
                'product_variant_id' => $variant->id,
                'nama_produk' => $variant->product->nama_produk,
                'nama_variasi' => $variant->nama_variasi,
                'qty' => $quantity, // Gunakan quantity dari request
                'harga' => $hargaSatuan, // Harga satuan
                'total' => $totalHarga, // Total = harga * quantity
                'price_option' => $price,

                'nama_pemesan' => $request->nama_pemesan,
                'no_hp' => $request->no_hp,
                'email' => $request->email,
                'alamat' => $request->alamat,
                'catatan_customer' => $request->catatan_customer,
                'file_desain' => $filePath,

                'kode_order' => $kodeOrder,
                'midtrans_order_id' => $kodeOrder,
                'payment_method' => 'midtrans',
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            $snapToken = MidtransService::createSnap($order);

            $order->update(['snap_token' => $snapToken]);

            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->id,
                'total' => $totalHarga
            ]);
        });
    }

    /**
     * Tampilkan halaman antrean percetakan
     */
    public function antrean(Request $request)
    {
        $query = Order::query()
            ->whereIn('payment_status', ['paid'])
            ->whereIn('status', ['diproses', 'menunggu', 'pending', 'selesai'])
            ->orderByRaw("CASE
            WHEN status = 'pending' THEN 1
            WHEN status = 'menunggu' THEN 2
            WHEN status = 'diproses' THEN 3
            WHEN status = 'selesai' THEN 4
            ELSE 5
        END")
            ->orderBy('paid_at', 'desc')
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan pencarian nomor antrean/kode order
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_order', 'like', "%{$search}%")
                    ->orWhere('midtrans_order_id', 'like', "%{$search}%")
                    ->orWhere('nama_pemesan', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(16);

        return view('pages.antrean', compact('orders'));
    }

    /**
     * API endpoint untuk pencarian antrean (opsional)
     */
    public function searchAntrean(Request $request)
    {
        $search = $request->input('q');

        $orders = Order::query()
            ->whereIn('payment_status', ['paid'])
            ->whereIn('status', ['diproses', 'menunggu', 'pending', 'selesai'])
            ->where(function ($q) use ($search) {
                $q->where('kode_order', 'like', "%{$search}%")
                    ->orWhere('midtrans_order_id', 'like', "%{$search}%")
                    ->orWhere('nama_pemesan', 'like', "%{$search}%");
            })
            ->orderByRaw("CASE
            WHEN status = 'pending' THEN 1
            WHEN status = 'menunggu' THEN 2
            WHEN status = 'diproses' THEN 3
            WHEN status = 'selesai' THEN 4
            ELSE 5
        END")
            ->orderBy('paid_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($orders);
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,menunggu,selesai,dibatalkan'
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }
}
