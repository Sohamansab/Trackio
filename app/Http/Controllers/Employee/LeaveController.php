<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use App\Models\User;
use App\Models\Notification;

class LeaveController extends Controller
{
    public function index()
    {
        $employee = auth()->user()->employeeProfile;
        $leaves = [];
        $leaveBalances = [];
        if ($employee) {
            $leaves = LeaveRequest::where('emp_id', $employee->emp_id)
                ->with('type')
                ->orderBy('start_date','desc')
                ->get();

            $leaveBalances = LeaveBalance::where('emp_id', $employee->emp_id)
                ->with('leaveType')
                ->get();
        }
        return view('employee.leaves.index', compact('leaves', 'leaveBalances'));
    }

    public function create()
    {
        $types = LeaveType::all();
        return view('employee.leaves.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,leave_type_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        $employee = auth()->user()->employeeProfile;
        if (! $employee) {
            return back()->withErrors('No employee profile found.');
        }

        $leave = LeaveRequest::create([
            'emp_id' => $employee->emp_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'Pending',
            'reason' => $request->reason,
        ]);

        // Send notification to all admin users
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->user_id,
                'title' => 'New Leave Request',
                'message' => "{$employee->first_name} {$employee->last_name} has submitted a leave request from {$leave->start_date} to {$leave->end_date}.",
                'type' => 'leave_request'
            ]);
        }

        return redirect()->route('employee.leaves.index')->with('success','Leave request submitted.');
    }
}
