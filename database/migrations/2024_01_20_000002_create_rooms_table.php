<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->enum('type', ['Single', 'Double', 'Suite', 'King', 'Twin', 'Appartment']);
            $table->integer('floor');
            $table->decimal('base_price', 10, 2);
            $table->enum('status', ['available', 'occupied', 'booked', 'cleaning', 'maintenance'])->default('available');
            $table->integer('guests')->default(0);
            $table->enum('stay_type', ['ម៉ោង', 'យប់', 'ខែ'])->nullable();
            $table->date('check_in_date')->nullable();
            $table->time('check_in_time')->nullable();
            $table->string('overtime')->default('0');
            $table->string('guest_name')->nullable();
            $table->string('phone')->nullable();
            $table->decimal('deposit', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
