<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\LeaveBalance;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employeeProfile()->with('shift')->firstOrFail();

        if (!$employee) {
            return redirect()->route('login');
        }

        // Get today's attendance status
        $today = Carbon::today()->toDateString();
        $todaysAttendance = Attendance::where('emp_id', $employee->emp_id)
            ->where('date', $today)
            ->first();

        $todaysStatus = ['status' => 'Not Marked', 'check_in' => null, 'details' => []];

        if ($todaysAttendance) {
            // Determine if late or on time based on shift
            $shift = $employee->shift;
            if ($shift && $todaysAttendance->check_in) {
                $checkInTime = Carbon::parse($todaysAttendance->check_in);
                $shiftStart = Carbon::parse($shift->start_time);

                if ($checkInTime->gt($shiftStart)) {
                    $minutesLate = $checkInTime->diffInMinutes($shiftStart);
                    $todaysStatus = [
                        'status' => 'Late',
                        'check_in' => $checkInTime->format('H:i'),
                        'details' => ['minutes_late' => $minutesLate]
                    ];
                } else {
                    $todaysStatus = [
                        'status' => 'On Time',
                        'check_in' => $checkInTime->format('H:i'),
                        'details' => []
                    ];
                }
            } else {
                $todaysStatus = [
                    'status' => 'Present',
                    'check_in' => $todaysAttendance->check_in ? Carbon::parse($todaysAttendance->check_in)->format('H:i') : null,
                    'details' => []
                ];
            }
        }

        // Get recent attendance records (last 10)
        $recentAttendance = Attendance::where('emp_id', $employee->emp_id)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        // Get selected month from request, default to current month
        $selectedMonth = $request->get('month', Carbon::now()->format('Y-m'));
        $selectedDate = Carbon::createFromFormat('Y-m', $selectedMonth);
        $currentMonth = $selectedDate->month;
        $currentYear = $selectedDate->year;

        // Get attendance records for selected month
        $attendanceRecords = Attendance::where('emp_id', $employee->emp_id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->orderBy('date', 'desc')
            ->get();

        // Get holidays for selected month
        $holidays = Holiday::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->pluck('date')
            ->toArray();

        // Calculate working days in selected month (excluding weekends and holidays)
        $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $endOfMonth = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        $workingDays = 0;
        $totalDays = 0;

        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $totalDays++;
            // Skip weekends and holidays
            if (!$date->isWeekend() && !in_array($date->toDateString(), $holidays)) {
                $workingDays++;
            }
        }

        // Calculate attendance statistics for selected month (case-insensitive)
        $presentCount = $attendanceRecords->filter(function($record) {
            return strtolower($record->status) === 'present';
        })->count();
        $absentCount = $attendanceRecords->filter(function($record) {
            return strtolower($record->status) === 'absent';
        })->count();
        $leaveCount = $attendanceRecords->filter(function($record) {
            return strtolower($record->status) === 'leave';
        })->count();
        $halfDayCount = $attendanceRecords->filter(function($record) {
            return strtolower($record->status) === 'half-day';
        })->count();

        // Calculate unmarked days (days that should be working days but no attendance record) - only for past dates
        $unmarkedDays = 0;
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->toDateString();
            // Only count working days (not weekends or holidays) and only past dates
            if (!$date->isWeekend() && !in_array($dateString, $holidays) && $date->lte(Carbon::today())) {
                $hasRecord = $attendanceRecords->contains('date', $dateString);
                if (!$hasRecord) {
                    $unmarkedDays++;
                }
            }
        }

        // Calculate total leave days using the same logic as the chart
        $totalLeaveDays = 0;

        // Get approved leave requests for the month
        $leaveRequests = LeaveRequest::where('emp_id', $employee->emp_id)
            ->where('status', 'approved')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                      ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                      ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                          $q->where('start_date', '<=', $startOfMonth)
                            ->where('end_date', '>=', $endOfMonth);
                      });
            })
            ->get();

        // Build array of leave dates (same as chart)
        $leaveDates = [];
        foreach ($leaveRequests as $leave) {
            $leaveStart = Carbon::parse($leave->start_date);
            $leaveEnd = Carbon::parse($leave->end_date);

            // Ensure we only include dates within the current month
            $currentStart = $leaveStart->max($startOfMonth);
            $currentEnd = $leaveEnd->min($endOfMonth);

            for ($date = $currentStart->copy(); $date->lte($currentEnd); $date->addDay()) {
                $leaveDates[$date->format('Y-m-d')] = true;
            }
        }

        // Count leave days same as chart logic (case-insensitive)
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->toDateString();
            $attendanceRecord = $attendanceRecords->firstWhere('date', $dateString);
            $status = $attendanceRecord ? strtolower($attendanceRecord->status) : null;
            if (!$status && isset($leaveDates[$dateString])) {
                $status = 'leave';
            }

            if ($status === 'leave') {
                $totalLeaveDays++;
            }
        }

        // Get leave balances
        $leaveBalances = LeaveBalance::where('emp_id', $employee->emp_id)
            ->with('leaveType')
            ->get();

        // Calculate monthly summary
        $monthlySummary = [
            'total_working_days' => $workingDays,
            'total_present' => $presentCount,
            'total_absent' => $absentCount + $unmarkedDays, // Include unmarked days as absent
            'total_leave' => $totalLeaveDays,
            'total_half_day' => $halfDayCount,
            'unmarked_days' => $unmarkedDays,
            'attendance_percentage' => $workingDays > 0 ? round((($presentCount + $halfDayCount * 0.5) / $workingDays) * 100, 1) : 0
        ];

        // Prepare chart data for selected month only
        $chartData = $this->getAttendanceChartData($employee->emp_id, $selectedDate);

        // Generate month options for dropdown (previous months only)
        $monthOptions = $this->getMonthOptions();

        // Get month name for display
        $monthName = $selectedDate->format('F Y');

        return view('employee.dashboard', compact(
            'attendanceRecords',
            'presentCount',
            'absentCount',
            'leaveCount',
            'halfDayCount',
            'leaveBalances',
            'monthlySummary',
            'unmarkedDays',
            'chartData',
            'selectedMonth',
            'monthOptions',
            'monthName',
            'todaysStatus',
            'recentAttendance'
        ));
    }

    private function getAttendanceChartData($empId, $selectedDate)
    {
        $chartData = [];

        // Get holidays for selected month
        $holidays = Holiday::whereYear('date', $selectedDate->year)
            ->whereMonth('date', $selectedDate->month)
            ->pluck('date')
            ->toArray();

        // Get start and end of month
        $startOfMonth = Carbon::create($selectedDate->year, $selectedDate->month, 1);
        $endOfMonth = Carbon::create($selectedDate->year, $selectedDate->month, 1)->endOfMonth();

        // Get attendance records for the month
        $attendanceRecords = Attendance::where('emp_id', $empId)
            ->whereYear('date', $selectedDate->year)
            ->whereMonth('date', $selectedDate->month)
            ->get()
            ->keyBy(function ($record) {
                return $record->date->toDateString();
            });

        // Get approved leave requests for the month
        $leaveDates = [];
        $leaveRequests = LeaveRequest::where('emp_id', $empId)
            ->where('status', 'approved')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                      ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth])
                      ->orWhere(function ($q) use ($startOfMonth, $endOfMonth) {
                          $q->where('start_date', '<=', $startOfMonth)
                            ->where('end_date', '>=', $endOfMonth);
                      });
            })
            ->get();

        // Build array of leave dates
        foreach ($leaveRequests as $leave) {
            $leaveStart = Carbon::parse($leave->start_date);
            $leaveEnd = Carbon::parse($leave->end_date);

            // Ensure we only include dates within the current month
            $currentStart = $leaveStart->max($startOfMonth);
            $currentEnd = $leaveEnd->min($endOfMonth);

            for ($date = $currentStart->copy(); $date->lte($currentEnd); $date->addDay()) {
                $leaveDates[$date->format('Y-m-d')] = true;
            }
        }

        // Generate data for each day of the month
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dateString = $date->toDateString();
            $dayOfMonth = $date->day;
            $dayName = $date->format('D');

            // Determine status for this day (case-insensitive)
            $attendanceRecord = $attendanceRecords[$dateString] ?? null;
            $status = $attendanceRecord ? strtolower($attendanceRecord->status) : null;
            if (!$status && isset($leaveDates[$dateString])) {
                $status = 'leave';
            }

            // Treat unmarked working days as absent (only for past dates)
            if (!$status && !$date->isWeekend() && !in_array($dateString, $holidays) && $date->lte(Carbon::today())) {
                $status = 'absent';
            }

            // Determine value and color based on status
            $value = 0;
            $color = '#e5e7eb'; // Default gray for no data

            if ($status === 'present') {
                $value = 1;
                $color = '#22c55e'; // Green
            } elseif ($status === 'half-day') {
                $value = 0.5;
                $color = '#f59e0b'; // Orange
            } elseif ($status === 'absent') {
                $value = 0.25;
                $color = '#ef4444'; // Red
            } elseif ($status === 'leave') {
                $value = 0.75;
                $color = '#8b5cf6'; // Purple
            } elseif ($date->isWeekend()) {
                $value = 1;
                $color = '#000000'; // Black for weekends
            } elseif (in_array($dateString, $holidays)) {
                $value = 0;
                $color = '#3b82f6'; // Blue for holidays
            }

            $chartData[] = [
                'day' => $dayOfMonth,
                'date' => $dateString,
                'day_name' => $dayName,
                'status' => $status ?? 'no_data',
                'value' => $value,
                'color' => $color,
                'check_in' => $attendanceRecord && $attendanceRecord->check_in ? $attendanceRecord->check_in->format('H:i') : null,
                'check_out' => $attendanceRecord && $attendanceRecord->check_out ? $attendanceRecord->check_out->format('H:i') : null
            ];
        }

        return $chartData;
    }

    private function getMonthOptions()
    {
        $options = [];
        $currentDate = Carbon::now();

        // Generate options for current month and previous 11 months (1 year back)
        for ($i = 0; $i < 12; $i++) {
            $month = $currentDate->copy()->subMonths($i);
            $value = $month->format('Y-m');
            $label = $month->format('M Y');
            $options[$value] = $label;
        }

        return $options;
    }
}
