<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        // produk
        'product_id',
        'product_variant_id',
        'nama_produk',
        'nama_variasi',
        'qty',
        'harga',
        'total',
        'price_option',

        // customer
        'nama_pemesan',
        'no_hp',
        'email',
        'alamat',
        'catatan_customer',
        'file_desain',

        // payment (midtrans)
        'kode_order',
        'midtrans_order_id',
        'snap_token',
        'payment_method',
        'payment_status',
        'paid_at',

        // workflow
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
        'price_option' => 'array',
        'paid_at' => 'datetime',
    ];

    /* ========================
     | RELATIONSHIPS
     |======================== */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /* ========================
     | HELPERS
     |======================== */
    public function calculateTotal(): void
    {
        $this->total = $this->qty * $this->harga;
        $this->save();
    }

    public function markAsPaid(string $method = null): void
    {
        $this->update([
            'payment_status' => 'paid',
            'payment_method' => $method,
            'paid_at' => now(),
            'status' => 'diproses',
        ]);
    }
}
