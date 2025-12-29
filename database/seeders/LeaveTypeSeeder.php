<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'annual_allowed' => 24],
            ['name' => 'Unpaid Leave Contractual', 'annual_allowed' => 40],
            ['name' => 'Unpaid Leave', 'annual_allowed' => 10],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create($type);
        }
    }
}
