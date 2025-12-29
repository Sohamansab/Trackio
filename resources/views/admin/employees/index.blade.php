@extends('layouts.admin')

@section('title', 'Employees')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All Employees</h4>
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
            + Add Employee
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Shift</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->employee_code ?? 'N/A' }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->department->department_name ?? 'N/A' }}</td>
                                <td>{{ $employee->designation->designation_name ?? 'N/A' }}</td>
                                <td>{{ $employee->shift->shift_name ?? 'N/A' }}</td>
                                <td>
                                    @if($employee->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.employees.edit', $employee->emp_id) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>

                                    @if($employee->qr_code)
                                        <a href="{{ route('admin.employee.qr.show', $employee->emp_id) }}" class="btn btn-sm btn-info">QR</a>
                                    @else
                                        <a href="{{ route('admin.employee.qr.generate', $employee->emp_id) }}" class="btn btn-sm btn-success">Generate QR</a>
                                    @endif

                                    <form action="{{ route('admin.employees.destroy', $employee->emp_id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this employee?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No employees found. <a href="{{ route('admin.employees.create') }}">Add one now</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

