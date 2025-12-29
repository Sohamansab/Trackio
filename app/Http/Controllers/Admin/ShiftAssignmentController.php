<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShiftAssignment;
use App\Models\EmployeeProfile;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftAssignmentController extends Controller
{
    public function index() {
        return view('admin.shift_assignments.index', [
            'assignments' => ShiftAssignment::with(['employee', 'shift'])->get()
        ]);
    }

    public function create() {
        return view('admin.shift_assignments.create', [
            'employees' => EmployeeProfile::all(),
            'shifts' => Shift::all()
        ]);
    }

    public function store(Request $request) {
        ShiftAssignment::create($request->all());
        return back();
    }

    public function destroy(ShiftAssignment $shiftAssignment) {
        $shiftAssignment->delete();
        return back();
    }
}
