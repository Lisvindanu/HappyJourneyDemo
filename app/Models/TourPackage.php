<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourPackage extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'destination',
        'category',
        'duration',
        'airline',
        'price_adult',
        'price_child',
        'price_single_supplement',
        'price_infant',
        'deposit',
        'min_participants',
        'departure_dates',
        'highlights',
        'itinerary',
        'inclusions',
        'exclusions',
        'image',
        'pdf_file',
        'discount_percent',
        'original_price',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'departure_dates'   => 'array',
        'highlights'        => 'array',
        'itinerary'         => 'array',
        'inclusions'        => 'array',
        'exclusions'        => 'array',
        'is_featured'       => 'boolean',
        'is_active'         => 'boolean',
        'price_adult'       => 'decimal:0',
        'price_child'       => 'decimal:0',
        'price_single_supplement' => 'decimal:0',
        'price_infant'      => 'decimal:0',
        'deposit'           => 'decimal:0',
        'original_price'    => 'decimal:0',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get a human-readable formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price_adult, 0, ',', '.');
    }

    /**
     * Get the package image URL, falling back to a local placeholder by destination.
     */
    public function getDisplayImageAttribute(): string
    {
        if ($this->image) {
            return $this->image;
        }

        $fallbacks = [
            'korea'   => '/images/packages/korea-6d-shocking-sale.jpg',
            'jepang'  => '/images/packages/japan-featured.jpg',
            'china'   => '/images/packages/china-8d-shanghai-beijing.jpg',
            'eropa'   => '/images/packages/europe-west.jpg',
            'vietnam' => '/images/blog/vietnam-halong-sapa.jpg',
        ];

        $dest = strtolower($this->destination);
        foreach ($fallbacks as $key => $path) {
            if (str_contains($dest, $key)) {
                return $path;
            }
        }
        return '/images/packages/japan-featured.jpg';
    }

    /**
     * Determine the category tab for filtering.
     */
    public function getCategoryTabAttribute(): string
    {
        $dest = strtolower($this->destination);
        if (in_array($dest, ['korea', 'jepang', 'china', 'vietnam', 'thailand'])) {
            return 'asia';
        }
        if (str_contains($dest, 'eropa')) {
            return 'eropa';
        }
        return 'asia';
    }
}
