@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('admin.attendance-adjustments.index') }}" class="btn btn-secondary mb-3">&larr; Back to List</a>
    
    <div class="card">
        <div class="card-header">
            <h3>Adjustment Request Details</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Employee:</strong> {{ $adjustment->employee->name ?? 'N/A' }}
                </div>
                <div class="col-md-6">
                    <strong>Employee Code:</strong> {{ $adjustment->employee->employeeProfile->employee_code ?? 'N/A' }}
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Adjustment Type:</strong> {{ $adjustment->adjustment_type }}
                </div>
                <div class="col-md-6">
                    <strong>Adjustment Date:</strong> {{ $adjustment->adjustment_date->format('Y-m-d') }}
                </div>
            </div>
            <div class="mb-3">
                <strong>Reason:</strong>
                <div class="p-2 bg-light border rounded">{{ $adjustment->reason }}</div>
            </div>
            
            @if($adjustment->attachment)
                <div class="mb-3">
                    <strong>Attachment:</strong>
                    <a href="{{ asset('storage/' . $adjustment->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Attachment</a>
                </div>
            @endif

            <div class="mb-3">
                <strong>Status:</strong>
                <span class="badge bg-{{ $adjustment->status == 'approved' ? 'success' : ($adjustment->status == 'rejected' ? 'danger' : 'warning') }}">
                    {{ ucfirst($adjustment->status) }}
                </span>
            </div>

            @if($adjustment->status != 'pending')
                <div class="mb-3">
                    <strong>Admin Remark:</strong>
                    <p>{{ $adjustment->admin_remark }}</p>
                </div>
                <div class="mb-3">
                    <strong>Action By:</strong> {{ $adjustment->approver->name ?? 'N/A' }} at {{ $adjustment->approved_at ? $adjustment->approved_at->format('Y-m-d H:i') : '' }}
                </div>
            @endif
        </div>
        
        @if($adjustment->status == 'pending')
        <div class="card-footer">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.attendance-adjustments.approve', $adjustment->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Remark (Optional for Approval)</label>
                            <textarea name="admin_remark" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.attendance-adjustments.reject', $adjustment->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Remark (Required for Rejection)</label>
                            <textarea name="admin_remark" class="form-control" rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
