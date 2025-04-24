<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create sample users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'user1@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'user2@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'user3@example.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Sample users created successfully.');
    }
}
