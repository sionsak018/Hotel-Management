<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            // Floor 1
            ['number' => '101', 'type' => 'Single', 'floor' => 1, 'base_price' => 15.00],
            ['number' => '102', 'type' => 'Double', 'floor' => 1, 'base_price' => 25.00],
            ['number' => '103', 'type' => 'Double', 'floor' => 1, 'base_price' => 25.00],
            ['number' => '104', 'type' => 'Single', 'floor' => 1, 'base_price' => 15.00],
            ['number' => '105', 'type' => 'Suite', 'floor' => 1, 'base_price' => 45.00],

            // Floor 2
            ['number' => '201', 'type' => 'Double', 'floor' => 2, 'base_price' => 25.00],
            ['number' => '202', 'type' => 'Double', 'floor' => 2, 'base_price' => 25.00],
            ['number' => '203', 'type' => 'King', 'floor' => 2, 'base_price' => 35.00],
            ['number' => '204', 'type' => 'King', 'floor' => 2, 'base_price' => 35.00],
            ['number' => '205', 'type' => 'Twin', 'floor' => 2, 'base_price' => 30.00],

            // Floor 3
            ['number' => '301', 'type' => 'Appartment', 'floor' => 3, 'base_price' => 60.00],
            ['number' => '302', 'type' => 'Appartment', 'floor' => 3, 'base_price' => 60.00],
            ['number' => '303', 'type' => 'Suite', 'floor' => 3, 'base_price' => 45.00],
            ['number' => '304', 'type' => 'Suite', 'floor' => 3, 'base_price' => 45.00],
            ['number' => '305', 'type' => 'King', 'floor' => 3, 'base_price' => 35.00],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
