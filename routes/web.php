<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/destinasi-tour', [PackageController::class, 'destinations'])->name('packages.destinations');
Route::get('/paket-tour', [PackageController::class, 'index'])->name('packages.index');
Route::get('/paket-tour/{slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/paket-tour/{slug}/download-pdf', [PackageController::class, 'downloadPdf'])->name('packages.pdf');

Route::get('/inspirasi', [BlogController::class, 'index'])->name('blog.index');
Route::get('/inspirasi/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/inquiry', [InquiryController::class, 'store'])->name('inquiry.store');
