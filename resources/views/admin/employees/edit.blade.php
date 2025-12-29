@extends('layouts.admin')

@section('title', 'Edit Employee')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Employee: {{ $employee->name }}</h4>
        <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
            ← Back to List
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.employees.update', $employee->emp_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="employee_code" class="form-label">Employee Code</label>
                        <input type="text" class="form-control" id="employee_code" name="employee_code" 
                               value="{{ old('employee_code', $employee->employee_code) }}" readonly>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $employee->name) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $employee->email) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', $employee->phone) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->department_id }}" 
                                    {{ old('department_id', $employee->department_id) == $dept->department_id ? 'selected' : '' }}>
                                    {{ $dept->department_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="designation_id" class="form-label">Designation <span class="text-danger">*</span></label>
                        <select class="form-select" id="designation_id" name="designation_id" required>
                            <option value="">Select Designation</option>
                            @foreach($designations as $desig)
                                <option value="{{ $desig->designation_id }}" 
                                    {{ old('designation_id', $employee->designation_id) == $desig->designation_id ? 'selected' : '' }}>
                                    {{ $desig->designation_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="shift_id" class="form-label">Shift <span class="text-danger">*</span></label>
                        <select class="form-select" id="shift_id" name="shift_id" required>
                            <option value="">Select Shift</option>
                            @foreach($shifts as $shift)
                                <option value="{{ $shift->shift_id }}" 
                                    {{ old('shift_id', $employee->shift_id) == $shift->shift_id ? 'selected' : '' }}>
                                    {{ $shift->shift_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="joining_date" class="form-label">Joining Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="joining_date" name="joining_date" 
                               value="{{ old('joining_date', $employee->joining_date) }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="1" {{ $employee->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$employee->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="1">{{ old('address', $employee->address) }}</textarea>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

