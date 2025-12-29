<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeProfile;
use App\Models\Holiday;
use App\Models\LeaveRequest;
use App\Services\AttendanceService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $today = now()->toDateString();

        // Get total employees count
        $totalEmployees = EmployeeProfile::count();

        // Check if today is a working day
        $isWorkingDay = !Carbon::parse($today)->isWeekend() && !Holiday::where('date', $today)->exists();

        // Get attendance records for today
        $todaysAttendance = Attendance::where('date', $today)->get();

        // Calculate attendance statistics for today 
        $totalPresent = $todaysAttendance->filter(function($record) {
            return in_array(strtolower($record->status), ['present', 'late']);
        })->count();
        $totalLeave = $todaysAttendance->filter(function($record) {
            return strtolower($record->status) === 'leave';
        })->count();
        $totalHalfDay = $todaysAttendance->filter(function($record) {
            return strtolower($record->status) === 'half-day';
        })->count();

        // Calculate total absent only if today is a working day
        if ($isWorkingDay) {
            $totalPossibleAttendance = $totalEmployees;
            $totalActualAttendance = $totalPresent + ($totalHalfDay * 0.5);
            $totalAbsent = max(0, $totalPossibleAttendance - $totalActualAttendance - $totalLeave);
        } else {
            $totalAbsent = 0;
        }

        // Get pending leave requests count
        $pendingLeaves = LeaveRequest::where('status', 'pending')->count();

        // Get holidays for current month (for working days calculation)
        $holidays = Holiday::whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->pluck('date')
            ->toArray();

        // Calculate working days in the current month (excluding weekends and holidays)
        $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $endOfMonth = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();
        $workingDays = 0;
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            if (!$date->isWeekend() && !in_array($date->toDateString(), $holidays)) {
                $workingDays++;
            }
        }

        // Calculate how many employees were late today
        $todaysAttendance = Attendance::with('employee.shift')
            ->where('date', now()->toDateString())
            ->whereNotNull('check_in')
            ->get();

        $lateTodayCount = 0;
        $attendanceService = app(AttendanceService::class);
        foreach ($todaysAttendance as $record) {
            $shiftName = $record->employee->shift->name ?? 'morning'; // Default to 'morning'
            $statusDetails = $attendanceService->determineAttendanceStatus($shiftName, $record->check_in, $record->check_out);
            if ($statusDetails['check_in_status'] === 'Late') {
                $lateTodayCount++;
            }
        }

        // Monthly summary for admin
        $monthlySummary = [
            'total_employees' => $totalEmployees,
            'working_days' => $workingDays,
            'pending_leaves' => $pendingLeaves,
            'total_present' => $totalPresent,
            'total_absent' => $totalAbsent,
            'late_today' => $lateTodayCount,
        ];

        // Get recent attendance records (last 10)
        $recentAttendance = Attendance::with(['employee.user', 'employee.shift'])
            ->whereHas('employee.user')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('monthlySummary', 'recentAttendance', 'currentMonth', 'currentYear'));
    }
}
