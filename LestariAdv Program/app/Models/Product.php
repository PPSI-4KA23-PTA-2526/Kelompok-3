<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'catatan',
        'estimasi_pengerjaan_jam',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'estimasi_pengerjaan_jam' => 'integer',
    ];

    protected $appends = ['estimasi_formatted'];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama_produk');
    }

    // Accessors
    public function getPriceRangeAttribute(): string
    {
        $allPrices = $this->variants->flatMap(function ($variant) {
            return collect($variant->price_data ?? [])->pluck('harga');
        })->filter();

        if ($allPrices->isEmpty()) {
            return 'Belum ada harga';
        }

        $min = $allPrices->min();
        $max = $allPrices->max();

        if ($min === $max) {
            return 'Rp ' . number_format($min, 0, ',', '.');
        }

        return 'Rp ' . number_format($min, 0, ',', '.') . ' - Rp ' . number_format($max, 0, ',', '.');
    }

    public function getVariantsCountAttribute(): int
    {
        return $this->variants()->count();
    }

    public function getActiveVariantsCountAttribute(): int
    {
        return $this->variants()->where('is_active', true)->count();
    }

    public function getTotalPriceOptionsAttribute(): int
    {
        return $this->variants->sum(function ($variant) {
            return count($variant->price_data ?? []);
        });
    }

    // Accessor untuk format estimasi
    public function getEstimasiFormattedAttribute(): string
    {
        if (!$this->estimasi_pengerjaan_jam) {
            return '-';
        }

        $jam = $this->estimasi_pengerjaan_jam;

        if ($jam < 24) {
            return $jam . ' Jam';
        }

        $hari = floor($jam / 24);
        $sisaJam = $jam % 24;

        if ($sisaJam > 0) {
            return $hari . ' Hari ' . $sisaJam . ' Jam';
        }

        return $hari . ' Hari';
    }

    public function orders(): HasManyThrough
    {
        return $this->hasManyThrough(
            Order::class,
            Product::class,
            'category_id',
            'product_id'
        );
    }

    // Helper method untuk set estimasi dari hari
    public function setEstimasiHari(int $hari): void
    {
        $this->estimasi_pengerjaan_jam = $hari * 24;
    }

    // Helper method untuk get estimasi dalam hari
    public function getEstimasiHariAttribute(): float
    {
        return $this->estimasi_pengerjaan_jam ? $this->estimasi_pengerjaan_jam / 24 : 0;
    }
}
