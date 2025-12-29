<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::with('employees')->get();
        return view('admin.shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('admin.shifts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'grace_minutes' => 'nullable|integer|min:0|max:60',
        ]);

        Shift::create([
            'shift_name' => $request->shift_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'grace_minutes' => $request->grace_minutes ?? 0,
        ]);

        return redirect()->route('admin.shifts.index')
            ->with('success', 'Shift created successfully!');
    }

    public function edit($id)
    {
        $shift = Shift::findOrFail($id);
        return view('admin.shifts.edit', compact('shift'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'shift_name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required',
            'grace_minutes' => 'nullable|integer|min:0|max:60',
        ]);

        $shift = Shift::findOrFail($id);
        $shift->update([
            'shift_name' => $request->shift_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'grace_minutes' => $request->grace_minutes ?? 0,
        ]);

        return redirect()->route('admin.shifts.index')
            ->with('success', 'Shift updated successfully!');
    }

    public function destroy($id)
    {
        $shift = Shift::findOrFail($id);
        $shift->delete();

        return redirect()->route('admin.shifts.index')
            ->with('success', 'Shift deleted successfully!');
    }
}
