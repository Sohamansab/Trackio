<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\EmployeeProfile;
use App\Models\QrLog;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class QrAttendanceService
{
    /**
     * Record attendance from QR scan
     */
    public function recordAttendance(EmployeeProfile $employee, string $scanType = 'ecard-scan'): array
    {
        try {
            $today = Carbon::today();
            
            // Check if employee already has attendance record for today
            $attendance = Attendance::where('emp_id', $employee->emp_id)
                ->where('date', $today)
                ->first();

            if (!$attendance) {
                // First scan = Check-in
                // store timestamps in app timezone
                $now = now()->setTimezone(config('app.timezone'));
                    $attendance = Attendance::create([
                        'emp_id' => $employee->emp_id,
                        'date' => $today,
                        'check_in' => $now->format('H:i:s'),
                        // normalize status to match manual entries
                        'status' => 'Present',
                        'source_type' => 'qr'
                    ]);

                Log::info('QR Check-in Recorded', [
                    'emp_id' => $employee->emp_id,
                    'employee' => $employee->first_name . ' ' . $employee->last_name,
                    'check_in' => $attendance->check_in
                ]);

                return [
                    'success' => true,
                    'message' => 'Check-in recorded successfully',
                    'scan_type' => 'check-in',
                    'time' => $attendance->check_in,
                    'status' => $attendance->status
                ];
            } elseif (!$attendance->check_out) {
                // Second scan = Check-out
                $checkout = now()->setTimezone(config('app.timezone'));
                $attendance->update([
                    'check_out' => $checkout->format('H:i:s'),
                ]);

                Log::info('QR Check-out Recorded', [
                    'emp_id' => $employee->emp_id,
                    'employee' => $employee->first_name . ' ' . $employee->last_name,
                    'check_out' => $attendance->check_out
                ]);

                return [
                    'success' => true,
                    'message' => 'Check-out recorded successfully',
                    'scan_type' => 'check-out',
                    'time' => $attendance->check_out,
                    'duration' => $this->calculateDuration($attendance->check_in, $attendance->check_out)
                ];
            } else {
                // Already checked out - ignore additional scans
                return [
                    'success' => false,
                    'message' => 'Already checked out today',
                    'scan_type' => 'ignored'
                ];
            }
        } catch (\Exception $e) {
            Log::error('QR Attendance Recording Failed', [
                'emp_id' => $employee->emp_id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Determine attendance status (On-time, Late, etc.)
     */
    protected function determineStatus(EmployeeProfile $employee, Carbon $checkInTime): string
    {
        try {
            // Get employee's shift assignment for today
            $shift = $employee->shiftAssignments()
                ->where('start_date', '<=', Carbon::today())
                ->where(function ($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', Carbon::today());
                })
                ->with('shift')
                ->first();

            if (!$shift || !$shift->shift) {
                return 'present'; // Default to present if no shift info
            }

            $shiftStart = Carbon::parse($shift->shift->start_time);
            $graceTime = $shift->shift->grace_time ?? 0; // in minutes

            if ($checkInTime->format('H:i') <= $shiftStart->addMinutes($graceTime)->format('H:i')) {
                return 'on-time';
            }

            return 'late';
        } catch (\Exception $e) {
            Log::warning('Error determining attendance status', [
                'error' => $e->getMessage()
            ]);
            return 'present';
        }
    }

    /**
     * Calculate work duration
     */
    protected function calculateDuration(Carbon $checkIn, Carbon $checkOut): string
    {
        $duration = $checkIn->diff($checkOut);
        $hours = $duration->h;
        $minutes = $duration->i;

        return "{$hours}h {$minutes}m";
    }

    /**
     * Log QR scan event
     */
    public function logQrScan(int $empId, string $scanType = 'ecard-scan'): void
    {
        QrLog::create([
            'emp_id' => $empId,
            'timestamp' => now(),
            'type' => $scanType
        ]);
    }
}
