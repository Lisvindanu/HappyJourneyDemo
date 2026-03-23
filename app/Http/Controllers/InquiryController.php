<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InquiryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|max:255',
                'phone'       => 'required|string|max:30',
                'destination' => 'nullable|string|max:255',
                'message'     => 'required|string|max:2000',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'error'   => 'Validasi gagal: ' . collect($e->errors())->flatten()->first(),
            ], 422);
        }

        Inquiry::create([
            'name'        => $validated['name'],
            'email'       => $validated['email'],
            'phone'       => $validated['phone'],
            'destination' => $validated['destination'] ?? null,
            'message'     => $validated['message'],
            'is_read'     => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesan konsultasi Anda berhasil terkirim! Tim kami akan segera menghubungi Anda.',
        ], 201);
    }
}
