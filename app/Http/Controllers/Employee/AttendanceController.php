<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index() {
        $employee = auth()->user()->employeeProfile;
        $records = [];
        if ($employee) {
            $records = Attendance::where('emp_id', $employee->emp_id)->get();
        }
        return view('employee.attendance.index', [
            'records' => $records
        ]);
    }

    public function today()
    {
        $employee = auth()->user()->employeeProfile;
        $attendance = null;
        if ($employee) {
            $attendance = Attendance::where('emp_id', $employee->emp_id)
                ->where('date', now()->toDateString())
                ->first();
        }
        return view('employee.attendance', compact('attendance'));
    }
}
