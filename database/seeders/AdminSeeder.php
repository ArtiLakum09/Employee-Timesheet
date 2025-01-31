<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // Make sure to hash the password
        ]);

        // You can add more admin records if needed
        Admin::create([
            'name' => 'Admin User',
            'email' => 'admin2@example.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
