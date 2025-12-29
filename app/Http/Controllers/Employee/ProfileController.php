<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\EmployeeProfile;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        $designations = Designation::all();
        $shifts = Shift::all();

        // return view('employee.profile.create', compact('departments', 'designations', 'shifts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|string|unique:employee_profiles',
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,department_id',
            'designation_id' => 'required|exists:designations,designation_id',
            'shift_id' => 'required|exists:shifts,shift_id',
            'email' => 'required|email|unique:employee_profiles',
            'phone' => 'required|string|max:20',
            'joining_date' => 'required|date',
            'address' => 'required|string',
        ]);

        EmployeeProfile::create([
            'user_id' => Auth::id(),
            'employee_code' => $request->employee_code,
            'name' => $request->name,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'shift_id' => $request->shift_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'joining_date' => $request->joining_date,
            'address' => $request->address,
            'status' => 'active',
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
