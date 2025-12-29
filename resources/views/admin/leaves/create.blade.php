@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3>Add Manual Leave</h3>

    <form action="{{ route('admin.leaves.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Employee</label>
            <select name="emp_id" class="form-control" required>
                <option value="">Select Employee</option>
                @foreach(\App\Models\EmployeeProfile::where('status', true)->get() as $employee)
                    <option value="{{ $employee->emp_id }}">{{ $employee->employee_code }} - {{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Leave Type</label>
            <select name="leave_type_id" class="form-control" required>
                <option value="">Select Leave Type</option>
                @foreach($types as $type)
                    <option value="{{ $type->leave_type_id }}">{{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Reason</label>
            <textarea name="reason" class="form-control" rows="3"></textarea>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.leaves.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
