<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\EmployeeProfile;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
public function index() {
    $attendance = Attendance::with('employee')->orderBy('date','desc')->get();
    return view('admin.attendance.index', compact('attendance'));
}

public function create() {
    $employees = EmployeeProfile::all();
    return view('admin.attendance.create', compact('employees'));
}

public function store(Request $request) {
    $request->validate([
        'emp_id' => 'required|exists:employee_profiles,emp_id',
        'date' => 'required|date',
        'status' => 'required|in:Present,Absent,Leave,Half-day',
    ]);

    Attendance::create([
        'emp_id' => $request->emp_id,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'status' => $request->status,
        'source_type' => 'manual',
    ]);

    return redirect()->route('admin.attendance.index')->with('success','Attendance added successfully.');
}

public function edit($id) {
    $attendance = Attendance::findOrFail($id);
    $employees = EmployeeProfile::all();
    return view('admin.attendance.edit', compact('attendance', 'employees'));
}

public function update(Request $request, $id) {
    $request->validate([
        'emp_id' => 'required|exists:employee_profiles,emp_id',
        'date' => 'required|date',
        'status' => 'required|in:Present,Absent,Leave,Half-day',
    ]);

    $attendance = Attendance::findOrFail($id);
    $attendance->update([
        'emp_id' => $request->emp_id,
        'date' => $request->date,
        'check_in' => $request->check_in,
        'check_out' => $request->check_out,
        'status' => $request->status,
        'source_type' => 'manual',
    ]);

    return redirect()->route('admin.attendance.index')->with('success','Attendance updated successfully.');
}

public function destroy($id) {
    $attendance = Attendance::findOrFail($id);
    $attendance->delete();
    return redirect()->route('admin.attendance.index')->with('success','Attendance deleted successfully.');
}

}