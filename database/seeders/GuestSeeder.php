<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        $guests = [
            [
                'name' => 'សៅរា ម៉ួវិច្ឆិកា',
                'phone' => '012 345 678',
                'email' => 'sokha@gmail.com',
                'address' => 'ផ្ទះលេខ 123, ផ្លូវម៉ៅសេទុង, ភ្នំពេញ',
                'id_card_number' => '012345678901',
                'total_stays' => 5,
            ],
            [
                'name' => 'លី ហ៊ួរ',
                'phone' => '010 111 222',
                'email' => 'lyhuor@gmail.com',
                'address' => 'ផ្ទះលេខ 456, ផ្លូវព្រះស៊ីសុវត្ថិ, ភ្នំពេញ',
                'id_card_number' => '012345678902',
                'total_stays' => 3,
            ],
            [
                'name' => 'រដ្ឋា វិបុល',
                'phone' => '011 222 333',
                'email' => 'rattha@gmail.com',
                'address' => 'ផ្ទះលេខ 789, ផ្លូវព្រះនរោត្តម, ភ្នំពេញ',
                'id_card_number' => '012345678903',
                'total_stays' => 2,
            ],
            [
                'name' => 'វណ្ណា សុខុម',
                'phone' => '015 555 666',
                'email' => 'vanna@gmail.com',
                'address' => 'ផ្ទះលេខ 321, ផ្លូវម៉ៅសេទុង, ភ្នំពេញ',
                'id_card_number' => '012345678904',
                'total_stays' => 1,
            ],
        ];

        foreach ($guests as $guest) {
            Guest::create($guest);
        }
    }
}
