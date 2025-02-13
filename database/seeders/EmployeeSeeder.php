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
            'name' => 'Reema',
            'email' => 'employee1@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'Arti',
            'email' => 'employee2@example.com',
            'password' => Hash::make('employee123'),
        ]);
         //
         // Creating an employee user
         Employee::create([
            'name' => 'Kunj',
            'email' => 'employee3@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'vivan',
            'email' => 'employee4@example.com',
            'password' => Hash::make('employee123'),
        ]);
         //
         // Creating an employee user
         Employee::create([
            'name' => 'jony',
            'email' => 'employee5@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'viro',
            'email' => 'employee6@example.com',
            'password' => Hash::make('employee123'),
        ]);
        Employee::create([
            'name' => 'jony',
            'email' => 'employee17@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'viro',
            'email' => 'employee18@example.com',
            'password' => Hash::make('employee123'),
        ]);
        
        Employee::create([
            'name' => 'Sanvi',
            'email' => 'employee7@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'Veera',
            'email' => 'employee8@example.com',
            'password' => Hash::make('employee123'),
        ]);
        
        Employee::create([
            'name' => 'Nirali',
            'email' => 'employee9@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'Krupali',
            'email' => 'employee10@example.com',
            'password' => Hash::make('employee123'),
        ]);
        
        Employee::create([
            'name' => 'Swati',
            'email' => 'employee11@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'Grishma',
            'email' => 'employee12@example.com',
            'password' => Hash::make('employee123'),
        ]);
        
        Employee::create([
            'name' => 'Mihika',
            'email' => 'employee13@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'yug',
            'email' => 'employee14@example.com',
            'password' => Hash::make('employee123'),
        ]);
        
        Employee::create([
            'name' => 'aadit',
            'email' => 'employee15@example.com',
            'password' => Hash::make('employee123'), // Make sure to hash the password
        ]);

        // You can add more employee records if needed
        Employee::create([
            'name' => 'dev',
            'email' => 'employee16@example.com',
            'password' => Hash::make('employee123'),
        ]);
        
       
    }
}
