<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Make sure to import the User model

class UserSeeder extends Seeder
{
    public function run()
    {
        // Creating a single admin user
        User::create([
            'username' => 'admin', // Choose a username
            'email' => 'KarimTheAdmin@example.com', // Use a valid email
            'password' => Hash::make('KarimAdmin'), // Make sure to hash the password
            'role' => 'Admin', // Set the role as Admin
            'reputationPoints' => 1000, // Optional, set reputation points as needed
        ]);
    }
}
