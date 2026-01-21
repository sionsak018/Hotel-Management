<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // primary key

            // Foreign keys
            $table->foreignId('guest_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            // Booking info
            $table->date('check_in_date');
            $table->date('check_out_date')->nullable();
            $table->time('check_in_time');
            $table->time('check_out_time')->nullable();
            $table->enum('stay_type', ['ម៉ោង', 'យប់', 'ខែ']);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('deposit', 10, 2)->default(0);

            // Status & payment
            $table->enum('status', ['confirmed', 'checked_in', 'checked_out', 'cancelled'])->default('confirmed');
            $table->string('payment_method')->default('cash');

            // Optional info
            $table->string('id_card_image')->nullable();
            $table->text('special_requests')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
