<?php

namespace Database\Seeders;

use App\Models\EmployeeProfile;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = EmployeeProfile::all();
        $leaveTypes = LeaveType::all();

        foreach ($employees as $employee) {
            foreach ($leaveTypes as $leaveType) {
                LeaveBalance::create([
                    'emp_id' => $employee->emp_id,
                    'leave_type_id' => $leaveType->leave_type_id,
                    'remaining_leaves' => $leaveType->annual_allowed,
                ]);
            }
        }
    }
}
