@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Leave Requests</h4>
        <a href="{{ route('admin.leaves.create') }}" class="btn btn-primary">Add Leave (Admin)</a>
    </div>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Range</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $l->employee->name ?? 'N/A' }}</td>
                            <td>{{ $l->type->name ?? 'N/A' }}</td>
                            <td>{{ $l->start_date }} — {{ $l->end_date }}</td>
                            <td><span class="badge bg-secondary">{{ $l->status }}</span></td>
                            <td>
                                <a href="{{ route('admin.leaves.show', $l->leave_id) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center">No leave requests found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
