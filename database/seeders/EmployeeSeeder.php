<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         // Creating an employee user
         Employee::create([
            'name' => 'Employee One',
            'email' => 'employee1@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'Employee Two',
            'email' => 'employee2@example.com',
            'password' => Hash::make('employee123'),
        ]);
    }
}
