<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('destination');
            $table->string('category'); // asia, eropa, holyland, domestik, cruise
            $table->string('duration');
            $table->string('airline')->nullable();
            $table->decimal('price_adult', 12, 0);
            $table->decimal('price_child', 12, 0)->nullable();
            $table->decimal('price_single_supplement', 12, 0)->nullable();
            $table->decimal('price_infant', 12, 0)->nullable();
            $table->decimal('deposit', 12, 0)->nullable();
            $table->integer('min_participants')->default(20);
            $table->json('departure_dates')->nullable();
            $table->json('highlights')->nullable();
            $table->json('itinerary')->nullable();
            $table->json('inclusions')->nullable();
            $table->json('exclusions')->nullable();
            $table->string('image')->nullable();
            $table->string('pdf_file')->nullable();
            $table->integer('discount_percent')->nullable();
            $table->decimal('original_price', 12, 0)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
