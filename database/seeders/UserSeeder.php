<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username' => 'EmilyClark',
                'email' => 'emilyclark@example.com',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'reputationPoints' => 150,
            ],
            [
                'username' => 'MichaelBrown',
                'email' => 'michaelbrown@example.com',
                'password' => Hash::make('password123'),
                'role' => 'User',
                'reputationPoints' => 80,
            ],
            [
                'username' => 'SophiaWilson',
                'email' => 'sophiawilson@example.com',
                'password' => Hash::make('password123'),
                'role' => 'User',
                'reputationPoints' => 95,
            ],
            [
                'username' => 'DanielTaylor',
                'email' => 'danieltaylor@example.com',
                'password' => Hash::make('password123'),
                'role' => 'User',
                'reputationPoints' => 45,
            ],
            [
                'username' => 'OliviaMoore',
                'email' => 'oliviamoore@example.com',
                'password' => Hash::make('password123'),
                'role' => 'User',
                'reputationPoints' => 60,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}