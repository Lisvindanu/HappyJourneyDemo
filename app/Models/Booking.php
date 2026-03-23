<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'booking_code',
        'tour_package_id',
        'package_name',
        'destination',
        'price_per_person',
        'customer_name',
        'email',
        'phone',
        'passengers',
        'travel_date',
        'notes',
        'status',
        'total_amount',
    ];

    protected $casts = [
        'travel_date'     => 'date',
        'price_per_person'=> 'decimal:0',
        'total_amount'    => 'decimal:0',
        'passengers'      => 'integer',
    ];

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    /**
     * Generate a unique booking code like HJ-20260323-XXXX.
     */
    public static function generateBookingCode(): string
    {
        $prefix    = 'HJ';
        $date      = now()->format('Ymd');
        $random    = strtoupper(substr(uniqid(), -4));
        $candidate = "{$prefix}-{$date}-{$random}";

        // Ensure uniqueness
        while (static::where('booking_code', $candidate)->exists()) {
            $random    = strtoupper(substr(uniqid(), -4));
            $candidate = "{$prefix}-{$date}-{$random}";
        }

        return $candidate;
    }
}
