<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $roomIds = DB::table('rooms')->pluck('id')->toArray();
        $guestIds = DB::table('guests')->pluck('id')->toArray();
        $userIds = DB::table('users')->pluck('id')->toArray();

        // Make sure tables have data
        if (empty($roomIds) || empty($guestIds) || empty($userIds)) {
            $this->command->info('Rooms, Guests, or Users table is empty. Seed them first!');
            return;
        }

        // Insert 10 sample bookings
        for ($i = 1; $i <= 10; $i++) {
            $checkIn = Carbon::now()->addDays(rand(0, 5));
            $checkOut = (clone $checkIn)->addDays(rand(1, 7));

            $booking = [
                'guest_id' => $faker->randomElement($guestIds),
                'user_id' => $faker->randomElement($userIds),
                'room_id' => $faker->randomElement($roomIds),
                'check_in_date' => $checkIn->toDateString(),
                'check_out_date' => $checkOut->toDateString(),
                'check_in_time' => $checkIn->format('H:i'),
                'check_out_time' => $checkOut->format('H:i'),
                'stay_type' => $faker->randomElement(['ម៉ោង', 'ថ្ងៃ', 'ខែ']),
                'total_amount' => $faker->numberBetween(50, 500),
                'deposit' => $faker->numberBetween(10, 100),
                'status' => $faker->randomElement(['មានភ្ញៀវ', 'ទំនេរ', 'កក់ទុក', 'កំពុងសម្អាត', 'ជួសជុល']),
                'payment_method' => $faker->randomElement(['cash', 'mobile']),
                'id_card_image' => 'id_cards/' . $faker->uuid . '.jpg',
                'special_requests' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('bookings')->insert($booking);
        }

        $this->command->info('10 bookings inserted successfully!');
    }
}
