@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h4>Leave Request Details</h4>
            <p><strong>Employee:</strong> {{ $leave->employee->name ?? 'N/A' }}</p>
            <p><strong>Type:</strong> {{ $leave->type->name ?? 'N/A' }}</p>
            <p><strong>Range:</strong> {{ $leave->start_date }} — {{ $leave->end_date }}</p>
            <p><strong>Status:</strong> {{ $leave->status }}</p>
            <p><strong>Reason:</strong> {{ $leave->reason }}</p>

            <div class="mt-4">
                @if($leave->status == 'Pending')
                <form method="POST" action="{{ route('admin.leaves.approve', $leave->leave_id) }}" class="d-inline">
                    @csrf
                    <button class="btn btn-success">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.leaves.reject', $leave->leave_id) }}" class="d-inline ms-2">
                    @csrf
                    <button class="btn btn-danger">Reject</button>
                </form>
                @endif
            </div>

            <hr>
            <h5>Approval Log</h5>
            <ul>
                @foreach($leave->approvals as $log)
                    <li>{{ $log->timestamp }} — {{ $log->status }} by {{ $log->approver->name ?? 'N/A' }} @if($log->comment) ({{ $log->comment }}) @endif</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
