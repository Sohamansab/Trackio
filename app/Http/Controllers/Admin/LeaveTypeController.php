<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveTypes = LeaveType::all();
        return view('admin.leave-types.index', compact('leaveTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leave-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'leave_type_name' => 'required|string|max:255|unique:leave_types,leave_type_name',
            'description' => 'nullable|string',
            'max_days' => 'required|integer|min:1',
        ]);

        LeaveType::create($request->all());

        return redirect()->route('admin.leave-types.index')->with('success', 'Leave type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);
        return view('admin.leave-types.show', compact('leaveType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);
        return view('admin.leave-types.edit', compact('leaveType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $request->validate([
            'leave_type_name' => 'required|string|max:255|unique:leave_types,leave_type_name,' . $id . ',leave_type_id',
            'description' => 'nullable|string',
            'max_days' => 'required|integer|min:1',
        ]);

        $leaveType->update($request->all());

        return redirect()->route('admin.leave-types.index')->with('success', 'Leave type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $leaveType = LeaveType::findOrFail($id);
        $leaveType->delete();

        return redirect()->route('admin.leave-types.index')->with('success', 'Leave type deleted successfully.');
    }
}
