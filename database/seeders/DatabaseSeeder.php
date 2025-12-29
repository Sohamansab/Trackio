<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::create([
            'name' => 'Test Employee',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 0, // employee
        ]);

        // Create employee profile for the test user
        \App\Models\EmployeeProfile::create([
            'user_id' => $user->user_id,
            'employee_code' => 'EMP001',
            'name' => $user->name,
            'email' => $user->email,
            'department_id' => 1,
            'designation_id' => 1,
            'shift_id' => null,
            'status' => true,
            'joining_date' => now()->format('Y-m-d'),
        ]);

        $this->call([
            EmployeeSeeder::class,
            AttendanceSeeder::class,
            LeaveTypeSeeder::class,
            LeaveBalanceSeeder::class,
        ]);
    }
}
