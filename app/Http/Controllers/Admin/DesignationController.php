<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    // Display all designations
    public function index()
    {
        $designations = Designation::with('employees')->get();
        return view('admin.designations.index', compact('designations'));
    }

    // Show form to create new designation
    public function create()
    {
        return view('admin.designations.create');
    }

    // Store new designation
    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|string|max:255',
        ]);

        Designation::create([
            'designation_name' => $request->designation_name,
        ]);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation created successfully.');
    }

    // Show single designation
    public function show($id)
    {
        $designation = Designation::findOrFail($id);
        return view('admin.designations.show', compact('designation'));
    }

    // Edit page
    public function edit($id)
    {
        $designation = Designation::findOrFail($id);
        return view('admin.designations.edit', compact('designation'));
    }

    // Update designation
    public function update(Request $request, $id)
    {
        $request->validate([
            'designation_name' => 'required|string|max:255',
        ]);

        $designation = Designation::findOrFail($id);

        $designation->update([
            'designation_name' => $request->designation_name,
        ]);

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation updated successfully.');
    }

    // Delete designation
    public function destroy($id)
    {
        $designation = Designation::findOrFail($id);
        $designation->delete();

        return redirect()->route('admin.designations.index')
            ->with('success', 'Designation deleted successfully.');
    }
}
