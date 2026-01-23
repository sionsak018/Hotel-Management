<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'check_out_date')) {
                $table->date('check_out_date')->nullable()->after('check_in_time');
            }
            if (!Schema::hasColumn('rooms', 'check_out_time')) {
                $table->time('check_out_time')->nullable()->after('check_out_date');
            }
            if (!Schema::hasColumn('rooms', 'gender')) {
                $table->string('gender')->nullable()->after('notes');
            }
            if (!Schema::hasColumn('rooms', 'age')) {
                $table->integer('age')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('rooms', 'address')) {
                $table->text('address')->nullable()->after('age');
            }
            if (!Schema::hasColumn('rooms', 'guest_type')) {
                $table->string('guest_type')->nullable()->after('address');
            }
            if (!Schema::hasColumn('rooms', 'id_type')) {
                $table->string('id_type')->nullable()->after('guest_type');
            }
            if (!Schema::hasColumn('rooms', 'country')) {
                $table->string('country')->nullable()->after('id_type');
            }
            if (!Schema::hasColumn('rooms', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('country');
            }
            if (!Schema::hasColumn('rooms', 'original_status')) {
                $table->string('original_status')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('rooms', 'booking_expiry')) {
                $table->timestamp('booking_expiry')->nullable()->after('original_status');
            }
            if (!Schema::hasColumn('rooms', 'overtime_hours')) {
                $table->integer('overtime_hours')->default(0)->after('booking_expiry');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'check_out_date',
                'check_out_time',
                'gender',
                'age',
                'address',
                'guest_type',
                'id_type',
                'country',
                'payment_method',
                'original_status',
                'booking_expiry',
                'overtime_hours'
            ]);
        });
    }
};
