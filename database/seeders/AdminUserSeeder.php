<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@formula1.hu'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create a regular user
        User::firstOrCreate(
            ['email' => 'user@formula1.hu'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role' => 'registered',
            ]
        );

        echo "Admin user created: admin@formula1.hu / password\n";
        echo "Regular user created: user@formula1.hu / password\n";
    }
}

