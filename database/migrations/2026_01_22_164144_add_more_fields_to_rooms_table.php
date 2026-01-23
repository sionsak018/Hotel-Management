<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('email')->nullable()->after('guest_name');
            $table->string('cart_id')->nullable()->after('phone');
            $table->integer('number_of_guests')->nullable()->after('deposit');
            $table->integer('children_count')->nullable()->after('number_of_guests');
            $table->string('gender')->nullable()->after('children_count');
            $table->integer('age')->nullable()->after('gender');
            $table->text('address')->nullable()->after('age');
            $table->string('guest_type')->nullable()->after('address');
            $table->string('id_type')->nullable()->after('guest_type');
            $table->string('country')->nullable()->after('id_type');
            $table->string('payment_method')->nullable()->after('country');
            $table->integer('overtime_hours')->default(0)->after('overtime');
            $table->string('original_status')->nullable()->after('overtime_hours');
            $table->timestamp('booking_expiry')->nullable()->after('original_status');
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'cart_id',
                'number_of_guests',
                'children_count',
                'gender',
                'age',
                'address',
                'guest_type',
                'id_type',
                'country',
                'payment_method',
                'overtime_hours',
                'original_status',
                'booking_expiry'
            ]);
        });
    }
};
