@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Attendance Adjustment Details</h3>
        <a href="{{ route('admin.attendance-adjustments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Employee:</strong> {{ $adjustment->employee?->name }}</p>
                    <p><strong>Employee ID:</strong> {{ $adjustment->employee?->employeeProfile?->emp_id ?? 'N/A' }}</p>
                    <p><strong>Type:</strong> {{ $adjustment->adjustment_type }}</p>
                    <p><strong>Date:</strong> {{ $adjustment->adjustment_date->format('Y-m-d') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Reason:</strong> {{ $adjustment->reason }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($adjustment->status) }}</p>
                    <p><strong>Applied At:</strong> {{ $adjustment->created_at->format('Y-m-d H:i') }}</p>
                    @if($adjustment->attachment)
                    <p><strong>Attachment:</strong> <a href="{{ Storage::url($adjustment->attachment) }}" target="_blank" class="btn btn-sm btn-info">View</a></p>
                    @endif
                </div>
            </div>

            @if($adjustment->status == 'pending')
            <div class="mt-4">
                <h5>Actions</h5>
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.attendance-adjustments.approve', $adjustment->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_remark_approve" class="form-label">Remark (optional)</label>
                                <textarea name="admin_remark" id="admin_remark_approve" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.attendance-adjustments.reject', $adjustment->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_remark_reject" class="form-label">Rejection Reason</label>
                                <textarea name="admin_remark" id="admin_remark_reject" class="form-control" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
    