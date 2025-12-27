<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Barbershop',
            'email' => 'admin@barbershop.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone_number' => '081234567890',
            'profile_picture' => null,
        ]);

        // Customer
        User::create([
            'name' => 'Customer Satu',
            'email' => 'customer@barbershop.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone_number' => '081298765432',
            'profile_picture' => null,
        ]);
    }
}
