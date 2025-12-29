<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('admin.departments.index', [
            'departments' => Department::all()
        ]);
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string'
        ]);

        Department::create([
            'department_name' => $request->department_name
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department added');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $department->update([
            'department_name' => $request->department_name
        ]);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return back()->with('success', 'Department deleted');
    }
}
