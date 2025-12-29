@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Attendance Adjustment Requests</h3>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Employee Name</th>
            <th>Employee ID</th>
            <th>Type</th>
            <th>Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Applied At</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($adjustments as $adjustment)
            <tr>
                <td>{{ $adjustment->employee->name }}</td>
                <td>{{ $adjustment->employee?->employeeProfile?->emp_id ?? 'N/A' }}</td>
                <td>{{ $adjustment->adjustment_type }}</td>
                <td>{{ $adjustment->adjustment_date->format('Y-m-d') }}</td>
                <td>{{ Str::limit($adjustment->reason, 50) }}</td>
                <td>{{ ucfirst($adjustment->status) }}</td>
                <td>{{ $adjustment->created_at->format('Y-m-d H:i') }}</td>
                <td>
                    <a href="{{ route('admin.attendance-adjustments.show', $adjustment->id) }}" class="btn btn-sm btn-primary">View</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
