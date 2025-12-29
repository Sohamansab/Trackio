@extends('layouts.admin')

@section('title', 'Attendance Management')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Attendance Records</h4>
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
            + Mark Attendance
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
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Source</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendance as $record)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $record->employee->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($record->date)->format('d-m-Y') }}</td>
                                <td>{{ $record->check_in ? \Carbon\Carbon::parse($record->check_in)->format('H:i') : '-' }}</td>
                                <td>{{ $record->check_out ? \Carbon\Carbon::parse($record->check_out)->format('H:i') : '-' }}</td>
                                <td>
                                    @if($record->status == 'Present')
                                        <span class="badge bg-success">Present</span>
                                    @elseif($record->status == 'Absent')
                                        <span class="badge bg-danger">Absent</span>
                                    @elseif($record->status == 'Leave')
                                        <span class="badge bg-warning">Leave</span>
                                    @else
                                        <span class="badge bg-info">Half-day</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($record->source_type) }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.attendance.edit', $record->attendance_id) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    
                                    <form action="{{ route('admin.attendance.destroy', $record->attendance_id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No attendance records found. <a href="{{ route('admin.attendance.create') }}">Mark one now</a>
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
