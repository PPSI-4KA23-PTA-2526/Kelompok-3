<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'nama_variasi',
        'images',
        'price_data',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'price_data' => 'array',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getPricesAttribute()
    {
        return collect($this->price_data ?? []);
    }

    public function getFirstImageAttribute(): ?string
    {
        $images = $this->images ?? [];
        return !empty($images) ? $images[0] : null;
    }

    public function getPriceRangeAttribute(): string
    {
        $prices = collect($this->price_data ?? [])->pluck('harga')->filter();

        if ($prices->isEmpty()) {
            return 'Belum ada harga';
        }

        $min = $prices->min();
        $max = $prices->max();

        if ($min === $max) {
            return 'Rp ' . number_format($min, 0, ',', '.');
        }

        return 'Rp ' . number_format($min, 0, ',', '.') . ' - Rp ' . number_format($max, 0, ',', '.');
    }

    public function getActivePricesAttribute()
    {
        return collect($this->price_data ?? [])->filter(function ($price) {
            return ($price['is_active'] ?? true) === true;
        });
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('nama_variasi');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
