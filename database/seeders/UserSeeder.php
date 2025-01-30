<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an Admin user
        User::create([
            'username' => 'adminuser2',
            'email' => 'admin2@example.com',
            'password' => Hash::make('password123'),  // Use a secure password
            'role' => 'Admin',
            'reputationPoints' => 100,
        ]);

        // Create a regular User
        User::create([
            'username' => 'regularuser',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),  // Use a secure password
            'role' => 'User',
            'reputationPoints' => 10,
        ]);
    }
}
