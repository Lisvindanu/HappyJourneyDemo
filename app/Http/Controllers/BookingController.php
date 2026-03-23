<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'package_slug'  => 'nullable|string',
                'package_name'  => 'required|string|max:255',
                'destination'   => 'required|string|max:255',
                'customer_name' => 'required|string|max:255',
                'email'         => 'required|email|max:255',
                'phone'         => 'required|string|max:30',
                'passengers'    => 'required|integer|min:1|max:50',
                'travel_date'   => 'required|date|after_or_equal:today',
                'notes'         => 'nullable|string|max:1000',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Validasi gagal: ' . collect($e->errors())->flatten()->first(),
            ], 422);
        }

        // Resolve package
        $package      = null;
        $pricePerPerson = 0;

        if (! empty($validated['package_slug'])) {
            $package = TourPackage::where('slug', $validated['package_slug'])->first();
            if ($package) {
                $pricePerPerson = (float) $package->price_adult;
            }
        }

        $passengers  = (int) $validated['passengers'];
        $totalAmount = $pricePerPerson * $passengers;

        $booking = Booking::create([
            'booking_code'    => Booking::generateBookingCode(),
            'tour_package_id' => $package?->id,
            'package_name'    => $validated['package_name'],
            'destination'     => $validated['destination'],
            'price_per_person'=> $pricePerPerson,
            'customer_name'   => $validated['customer_name'],
            'email'           => $validated['email'],
            'phone'           => $validated['phone'],
            'passengers'      => $passengers,
            'travel_date'     => $validated['travel_date'],
            'notes'           => $validated['notes'] ?? null,
            'status'          => 'pending',
            'total_amount'    => $totalAmount > 0 ? $totalAmount : null,
        ]);

        return response()->json([
            'success'      => true,
            'booking_code' => $booking->booking_code,
            'message'      => 'Booking berhasil! Tim kami akan segera menghubungi Anda.',
        ], 201);
    }
}
