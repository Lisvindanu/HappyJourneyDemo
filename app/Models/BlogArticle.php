<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogArticle extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'excerpt',
        'content',
        'image',
        'category',
        'read_time',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Return formatted published date in Indonesian.
     */
    public function getFormattedDateAttribute(): string
    {
        if (! $this->published_at) {
            return '';
        }

        $months = [
            1  => 'Januari', 2  => 'Februari', 3  => 'Maret',
            4  => 'April',   5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',    8  => 'Agustus',   9  => 'September',
            10 => 'Oktober', 11 => 'November',  12 => 'Desember',
        ];

        return $this->published_at->day . ' ' .
               $months[(int) $this->published_at->format('n')] . ' ' .
               $this->published_at->year;
    }

    /**
     * Get the article image URL, falling back to a local image by category.
     */
    public function getDisplayImageAttribute(): string
    {
        if ($this->image) {
            return $this->image;
        }

        $fallbacks = [
            'China'    => '/images/blog/china-zhangjiajie.jpg',
            'Vietnam'  => '/images/blog/vietnam-halong-sapa.jpg',
            'Jepang'   => '/images/blog/japan-city-fuji.jpg',
            'Korea'    => '/images/packages/korea-6d-shocking-sale.jpg',
            'Eropa'    => '/images/packages/europe-west.jpg',
            'Inspirasi'=> '/images/blog/blog-04.jpg',
            'Corporate'=> '/images/packages/korea-6d-hanbok.jpg',
        ];

        return $fallbacks[$this->category] ?? '/images/blog/blog-04.jpg';
    }
}
