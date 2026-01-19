<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'thumbnail_path',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get active portfolios ordered by order column
     */
    public static function getActivePortfolios()
    {
        return self::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get portfolio grouped by slides (2 items per slide)
     */
    public static function getPortfolioSlides()
    {
        $portfolios = self::getActivePortfolios();
        return $portfolios->chunk(2); // 2 items per slide
    }

    /**
     * Check if portfolio is image
     */
    public function isImage()
    {
        return $this->type === 'image';
    }

    /**
     * Check if portfolio is video
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Get full file URL
     */
    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Get full thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? Storage::url($this->thumbnail_path) : null;
    }

    /**
     * Boot method to handle file deletion
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($portfolio) {
            // Delete file when portfolio is deleted
            if ($portfolio->file_path && Storage::exists($portfolio->file_path)) {
                Storage::delete($portfolio->file_path);
            }

            // Delete thumbnail if exists
            if ($portfolio->thumbnail_path && Storage::exists($portfolio->thumbnail_path)) {
                Storage::delete($portfolio->thumbnail_path);
            }
        });
    }
}
