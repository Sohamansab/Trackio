@extends('layouts.employee')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>My Attendance Adjustment Requests</h3>
        <a href="{{ route('employee.attendance-adjustments.create') }}" class="btn btn-primary">+ New Request</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Type</th>
            <th>Date</th>
            <th>Status</th>
            <th>Applied At</th>
        </tr>
        </thead>

        <tbody>
        @foreach($adjustments as $adjustment)
            <tr>
                <td>{{ $adjustment->adjustment_type }}</td>
                <td>{{ $adjustment->adjustment_date->format('Y-m-d') }}</td>
                <td>{{ ucfirst($adjustment->status) }}</td>
                <td>{{ $adjustment->created_at->format('Y-m-d H:i') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
