<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Shift;
use App\Models\EmployeeProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('admin.employees.index', [
            'employees' => EmployeeProfile::with(['department','shift','designation'])->get()
        ]);
    }

    public function create()
    {
        return view('admin.employees.create', [
            'departments' => Department::all(),
            'shifts' => Shift::all(),
            'designations' => Designation::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_code' => 'required|unique:employee_profiles,employee_code',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employee_profiles,email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,department_id',
            'designation_id' => 'required|exists:designations,designation_id',
            'shift_id' => 'required|exists:shifts,shift_id',
            'joining_date' => 'required|date',
            'address' => 'nullable|string',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // Create user account for the employee
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 0, // Employee role
                'is_active' => 1,
            ]);

            // Create employee profile
            EmployeeProfile::create([
                'user_id' => $user->user_id,
                'employee_code' => $request->employee_code,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'shift_id' => $request->shift_id,
                'joining_date' => $request->joining_date,
                'address' => $request->address,
                'status' => 1,
            ]);

            DB::commit();
            return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create employee: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $employee = EmployeeProfile::findOrFail($id);
        return view('admin.employees.edit', [
            'employee' => $employee,
            'departments' => Department::all(),
            'shifts' => Shift::all(),
            'designations' => Designation::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $employee = EmployeeProfile::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employee_profiles,email,' . $employee->emp_id . ',emp_id',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,department_id',
            'designation_id' => 'required|exists:designations,designation_id',
            'shift_id' => 'required|exists:shifts,shift_id',
            'joining_date' => 'required|date',
            'status' => 'required|boolean',
        ]);

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department_id' => $request->department_id,
            'designation_id' => $request->designation_id,
            'shift_id' => $request->shift_id,
            'joining_date' => $request->joining_date,
            'address' => $request->address,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    public function destroy($id)
    {
        $employee = EmployeeProfile::findOrFail($id);

        // Also delete the associated user account
        if ($employee->user) {
            $employee->user->delete();
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}
