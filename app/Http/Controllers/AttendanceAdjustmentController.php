<?php

namespace App\Http\Controllers;

use App\Models\AttendanceAdjustment;
use App\Models\Attendance;
use App\Models\OfficeTiming;
use App\Notifications\AttendanceAdjustmentApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttendanceAdjustmentController extends Controller
{
    use AuthorizesRequests;

    // Employee methods
    public function create()
    {
        $this->authorize('create', AttendanceAdjustment::class);
        return view('employee.attendance-adjustments.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', AttendanceAdjustment::class);
        $request->validate([
            'adjustment_type' => 'required|string|in:Absent Adjustment,Late In Adjustment,Early Going Adjustment,Forgot to Mark Attendance,Forgot Attendance Card,Full Day Compensation,Outdoor Absent Adjustment,System Out Adjustment',
            'adjustment_date' => 'required|date|before_or_equal:today',
            'reason' => 'required|string|min:10',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Check if already exists
        $exists = AttendanceAdjustment::where('employee_id', auth()->id())
            ->where('adjustment_date', $request->adjustment_date)
            ->exists();
        if ($exists) {
            return back()->withErrors(['adjustment_date' => 'An adjustment request already exists for this date.']);
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attendance_adjustments', 'public');
        }

        AttendanceAdjustment::create([
            'employee_id' => auth()->id(),
            'adjustment_type' => $request->adjustment_type,
            'adjustment_date' => $request->adjustment_date,
            'reason' => $request->reason,
            'attachment' => $attachmentPath,
        ]);

        return redirect()->route('employee.attendance-adjustments.index')->with('success', 'Adjustment request submitted successfully.');
    }

    public function index()
    {
        $adjustments = AttendanceAdjustment::where('employee_id', auth()->id())->latest()->get();
        return view('employee.attendance-adjustments.index', compact('adjustments'));
    }

    // Admin methods
    public function adminIndex()
    {
        $this->authorize('viewAny', AttendanceAdjustment::class);
        $adjustments = AttendanceAdjustment::with('employee.employeeProfile')->latest()->get();
        return view('admin.attendance-adjustments.index', compact('adjustments'));
    }

    public function show($id)
    {
        $adjustment = AttendanceAdjustment::with('employee.employeeProfile')->findOrFail($id);
        $this->authorize('view', $adjustment);
        return view('admin.attendance-adjustments.show', compact('adjustment'));
    }

    public function approve(Request $request, $id)
    {
        $adjustment = AttendanceAdjustment::findOrFail($id);
        $this->authorize('update', $adjustment);
        $request->validate([
            'admin_remark' => 'nullable|string',
        ]);

        DB::transaction(function () use ($adjustment, $request) {
            $adjustment->update([
                'status' => 'approved',
                'admin_remark' => $request->admin_remark,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);
            $this->updateAttendance($adjustment);

            // Notify the employee
            $adjustment->employee->notify(new AttendanceAdjustmentApproved($adjustment));
        });

        return redirect()->route('admin.attendance-adjustments.index')->with('success', 'Adjustment approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $adjustment = AttendanceAdjustment::findOrFail($id);
        $this->authorize('update', $adjustment);
        $request->validate([
            'admin_remark' => 'required|string',
        ]);

        $adjustment->update([
            'status' => 'rejected',
            'admin_remark' => $request->admin_remark,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.attendance-adjustments.index')->with('success', 'Adjustment rejected successfully.');
    }

    private function updateAttendance(AttendanceAdjustment $adjustment)
    {
        $empId = $adjustment->employee->employeeProfile->emp_id;
        $attendance = Attendance::where('emp_id', $empId)
            ->where('date', $adjustment->adjustment_date)
            ->first();

        if (!$attendance) {
            $attendance = Attendance::create([
                'emp_id' => $empId,
                'date' => $adjustment->adjustment_date,
                'status' => 'present',
                'source_type' => 'manual',
            ]);
        }

        $officeTiming = OfficeTiming::first(); // Assume one office timing
        switch ($adjustment->adjustment_type) {
            case 'Absent Adjustment':
                $attendance->update(['status' => 'present']);
                break;
            case 'Late In Adjustment':
                $attendance->update(['check_in' => $officeTiming ? $officeTiming->start_time : '09:00:00']);
                break;
            case 'Early Going Adjustment':
                $attendance->update(['check_out' => $officeTiming ? $officeTiming->end_time : '18:00:00']);
                break;
            case 'Full Day Compensation':
                $attendance->update([
                    'status' => 'present',
                    'check_in' => $officeTiming ? $officeTiming->start_time : '09:00:00',
                    'check_out' => $officeTiming ? $officeTiming->end_time : '18:00:00',
                ]);
                break;
            default:
                $attendance->update(['status' => 'present']);
        }
    }
}
