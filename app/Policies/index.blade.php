@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance Adjustment Requests</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Applied On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($adjustments as $adj)
                        <tr>
                            <td>
                                {{ $adj->employee->name ?? 'N/A' }}<br>
                                <small class="text-muted">{{ $adj->employee->employeeProfile->employee_code ?? '' }}</small>
                            </td>
                            <td>{{ $adj->adjustment_date->format('Y-m-d') }}</td>
                            <td>{{ $adj->adjustment_type }}</td>
                            <td>
                                <span class="badge bg-{{ $adj->status == 'approved' ? 'success' : ($adj->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($adj->status) }}
                                </span>
                            </td>
                            <td>{{ $adj->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.attendance-adjustments.show', $adj->id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection