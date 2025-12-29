<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\LeaveApprovalLog;
use App\Models\LeaveBalance;
use App\Models\Attendance;
use App\Models\Notification;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = LeaveRequest::with(['employee','type'])->orderBy('start_date','desc')->get();
        return view('admin.leaves.index', compact('leaves'));
    }

    public function show($id)
    {
        $leave = LeaveRequest::with(['employee','type','approvals.approver'])->findOrFail($id);
        return view('admin.leaves.show', compact('leave'));
    }

    public function approve(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        if ($leave->status == 'Approved') {
            return back()->with('info','Leave already approved.');
        }

        $leave->status = 'Approved';
        $leave->save();

        LeaveApprovalLog::create([
            'leave_id' => $leave->leave_id,
            'approved_by' => auth()->id(),
            'status' => 'Approved',
            'timestamp' => now(),
            'comment' => $request->comment ?? null,
        ]);

        // Mark attendance records as 'Leave' for the leave period
        $startDate = Carbon::parse($leave->start_date);
        $endDate = Carbon::parse($leave->end_date);

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            Attendance::updateOrCreate(
                [
                    'emp_id' => $leave->emp_id,
                    'date' => $date->format('Y-m-d')
                ],
                [
                    'status' => 'Leave',
                    'source_type' => 'manual'
                ]
            );
        }

        // Deduct leave balance if available
        $days = $startDate->diffInDays($endDate) + 1;
        $balance = LeaveBalance::where('emp_id', $leave->emp_id)->where('leave_type_id', $leave->leave_type_id)->first();
        if ($balance) {
            $balance->remaining_leaves = max(0, $balance->remaining_leaves - $days);
            $balance->save();
        }

        // Send notification to employee
        Notification::create([
            'user_id' => $leave->employee->user_id,
            'title' => 'Leave Approved',
            'message' => "Your leave request from {$leave->start_date} to {$leave->end_date} has been approved.",
            'type' => 'leave_approval'
        ]);

        return redirect()->route('admin.leaves.index')->with('success','Leave approved.');
    }

    public function reject(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->status = 'Rejected';
        $leave->save();

        LeaveApprovalLog::create([
            'leave_id' => $leave->leave_id,
            'approved_by' => auth()->id(),
            'status' => 'Rejected',
            'timestamp' => now(),
            'comment' => $request->comment ?? null,
        ]);

        return redirect()->route('admin.leaves.index')->with('success','Leave rejected.');
    }

    // Admin can also create manual leave (approved immediately)
    public function create()
    {
        $types = LeaveType::all();
        return view('admin.leaves.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'emp_id' => 'required|exists:employee_profiles,emp_id',
            'leave_type_id' => 'required|exists:leave_types,leave_type_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $leave = LeaveRequest::create([
            'emp_id' => $request->emp_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Approved',
            'reason' => $request->reason,
        ]);

        LeaveApprovalLog::create([
            'leave_id' => $leave->leave_id,
            'approved_by' => auth()->id(),
            'status' => 'Approved',
            'timestamp' => now(),
            'comment' => 'Added manually by admin'
        ]);

        // Adjust balance
        $days = \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1;
        $balance = LeaveBalance::where('emp_id', $leave->emp_id)->where('leave_type_id', $leave->leave_type_id)->first();
        if ($balance) {
            $balance->remaining_leaves = max(0, $balance->remaining_leaves - $days);
            $balance->save();
        }

        return redirect()->route('admin.leaves.index')->with('success','Leave added.');
    }
}
