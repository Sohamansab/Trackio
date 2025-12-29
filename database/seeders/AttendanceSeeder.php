<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\EmployeeProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $employees = EmployeeProfile::all();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get working days for current month (excluding weekends)
        $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $endOfMonth = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        $workingDays = [];

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if (!$date->isWeekend()) {
                $workingDays[] = $date->toDateString();
            }
        }

        foreach ($employees as $employee) {
            foreach ($workingDays as $date) {
                // Randomly decide attendance status
                $rand = rand(1, 100);

                if ($rand <= 80) { // 80% present
                    $status = 'present';
                    $checkIn = Carbon::parse($date . ' 09:00:00')->addMinutes(rand(-30, 30)); // 8:30-9:30
                    $checkOut = Carbon::parse($date . ' 18:00:00')->addMinutes(rand(-30, 30)); // 17:30-18:30
                } elseif ($rand <= 90) { // 10% absent
                    $status = 'absent';
                    $checkIn = null;
                    $checkOut = null;
                } elseif ($rand <= 95) { // 5% leave
                    $status = 'leave';
                    $checkIn = null;
                    $checkOut = null;
                } else { // 5% half-day
                    $status = 'half-day';
                    $checkIn = Carbon::parse($date . ' 09:00:00')->addMinutes(rand(-30, 30));
                    $checkOut = Carbon::parse($date . ' 14:00:00')->addMinutes(rand(-30, 30)); // Early checkout
                }

                Attendance::firstOrCreate(
                    [
                        'employee_id' => $employee->employee_id,
                        'date' => $date,
                    ],
                    [
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'status' => $status,
                        'source_type' => collect(['qr', 'biometric', 'manual'])->random(),
                        'notes' => $status === 'present' ? 'Regular attendance' : null,
                    ]
                );
            }
        }
    }
}
