<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create 100 users
        for ($i = 1; $i <= 100; $i++) {
            User::create([
                'username' => 'user' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'), // Default password
                'role' => 'User',
                'reputationPoints' => rand(0, 1000), // Random reputation points
            ]);
        }
    }
}