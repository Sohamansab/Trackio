<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\EmployeeProfile;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Create departments
        $departments = [
            ['department_name' => 'IT', 'description' => 'Information Technology Department'],
            ['department_name' => 'HR', 'description' => 'Human Resources Department'],
            ['department_name' => 'Finance', 'description' => 'Finance Department'],
            ['department_name' => 'Marketing', 'description' => 'Marketing Department'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['department_name' => $dept['department_name']], $dept);
        }

        // Create designations
        $designations = [
            ['designation_name' => 'Software Engineer', 'department_id' => 1],
            ['designation_name' => 'HR Manager', 'department_id' => 2],
            ['designation_name' => 'Accountant', 'department_id' => 3],
            ['designation_name' => 'Marketing Specialist', 'department_id' => 4],
            ['designation_name' => 'System Administrator', 'department_id' => 1],
            ['designation_name' => 'HR Assistant', 'department_id' => 2],
        ];

        foreach ($designations as $desig) {
            Designation::firstOrCreate(['designation_name' => $desig['designation_name']], $desig);
        }

        // Create employees
        $employees = [
            [
                'name' => 'John Doe',
                'email' => 'john.doe@company.com',
                'emp_id' => 'EMP001',
                'department_id' => 1,
                'designation_id' => 1,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane.smith@company.com',
                'emp_id' => 'EMP002',
                'department_id' => 2,
                'designation_id' => 2,
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob.johnson@company.com',
                'emp_id' => 'EMP003',
                'department_id' => 3,
                'designation_id' => 3,
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice.brown@company.com',
                'emp_id' => 'EMP004',
                'department_id' => 4,
                'designation_id' => 4,
            ],
            [
                'name' => 'Charlie Wilson',
                'email' => 'charlie.wilson@company.com',
                'emp_id' => 'EMP005',
                'department_id' => 1,
                'designation_id' => 5,
            ],
            [
                'name' => 'Diana Davis',
                'email' => 'diana.davis@company.com',
                'emp_id' => 'EMP006',
                'department_id' => 2,
                'designation_id' => 6,
            ],
            [
                'name' => 'Edward Miller',
                'email' => 'edward.miller@company.com',
                'emp_id' => 'EMP007',
                'department_id' => 1,
                'designation_id' => 1,
            ],
            [
                'name' => 'Fiona Garcia',
                'email' => 'fiona.garcia@company.com',
                'emp_id' => 'EMP008',
                'department_id' => 3,
                'designation_id' => 3,
            ],
        ];

        foreach ($employees as $employee) {
            // Create user first
            $user = User::firstOrCreate(
                ['email' => $employee['email']],
                [
                    'name' => $employee['name'],
                    'password' => bcrypt('password'),
                    'role' => 0, // employee
                ]
            );

            // Create employee profile
            EmployeeProfile::firstOrCreate(
                ['user_id' => $user->user_id],
                [
                    'employee_code' => $employee['emp_id'],
                    'name' => $employee['name'],
                    'email' => $employee['email'],
                    'department_id' => $employee['department_id'],
                    'designation_id' => $employee['designation_id'],
                    'shift_id' => null,
                    'status' => true,
                    'joining_date' => now()->subDays(rand(30, 365))->format('Y-m-d'),
                ]
            );
        }
    }
}
