<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Services\AttendanceService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeDashboardController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
    }

    /**
     * Show the employee dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        // The 'employee.profile' middleware now guarantees the profile exists.
        // Using firstOrFail() is now safe and good practice here.
        $employee = $user->employeeProfile()->with('shift')->firstOrFail();

        // Get today's attendance record
        $todayAttendance = Attendance::where('emp_id', $employee->id)
            ->where('date', now()->toDateString())
            ->first();

        $todaysStatus = [
            'status' => 'Not Marked',
            'check_in' => null,
            'details' => null,
        ];

        if ($todayAttendance && $todayAttendance->check_in) {
            $shiftName = $employee->shift->name ?? 'morning'; // Default shift
            $statusDetails = $this->attendanceService->determineAttendanceStatus(
                $shiftName,
                $todayAttendance->check_in,
                $todayAttendance->check_out
            );

            $todaysStatus['status'] = $statusDetails['check_in_status'];
            $todaysStatus['check_in'] = Carbon::parse($todayAttendance->check_in)->format('h:i A');
            $todaysStatus['details'] = $statusDetails;
        }

        // Get recent attendance records for the employee (e.g., last 7 days)
        $recentAttendance = Attendance::where('emp_id', $employee->id)
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return view('employee.dashboard', compact('user', 'todaysStatus', 'recentAttendance'));
    }
}