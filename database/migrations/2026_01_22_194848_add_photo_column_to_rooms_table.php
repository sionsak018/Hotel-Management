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
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'photo')) {
                $table->string('photo')->nullable()->after('notes');
            }

            // បន្ថែមជួរឈរផ្សេងទៀតដែលបាត់
            $missingColumns = [
                'stay_type',
                'check_in_date',
                'check_in_time',
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
                'overtime',
                'overtime_hours',
                'children_count'
            ];

            foreach ($missingColumns as $column) {
                if (!Schema::hasColumn('rooms', $column)) {
                    switch ($column) {
                        case 'stay_type':
                        case 'gender':
                        case 'guest_type':
                        case 'id_type':
                        case 'country':
                        case 'payment_method':
                        case 'original_status':
                        case 'overtime':
                            $table->string($column)->nullable();
                            break;
                        case 'check_in_date':
                        case 'check_out_date':
                            $table->date($column)->nullable();
                            break;
                        case 'check_in_time':
                        case 'check_out_time':
                            $table->time($column)->nullable();
                            break;
                        case 'age':
                        case 'overtime_hours':
                        case 'children_count':
                            $table->integer($column)->nullable()->default(0);
                            break;
                        case 'address':
                            $table->text($column)->nullable();
                            break;
                        case 'booking_expiry':
                            $table->timestamp($column)->nullable();
                            break;
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Optional: Remove columns if needed
            // $table->dropColumn(['photo', 'stay_type', ...]);
        });
    }
};
