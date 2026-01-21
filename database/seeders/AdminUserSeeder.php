<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // First, update existing user if exists
        $user = User::where('email', 'admin@hotel.com')->first();

        if ($user) {
            $user->update([
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]);
            echo "Existing admin user updated!\n";
        } else {
            // Create new user if doesn't exist
            User::create([
                'name' => 'Admin',
                'email' => 'admin@hotel.com',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]);
            echo "New admin user created!\n";
        }

        echo "Login credentials:\n";
        echo "Email: admin@hotel.com\n";
        echo "Password: password123\n";
    }
}
