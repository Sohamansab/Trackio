@extends('layouts.employee')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>My Leave Requests</h4>
        <a href="{{ route('employee.leaves.create') }}" class="btn btn-primary">Apply For Leave</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Leave Balance Section -->
    @if(isset($leaveBalances) && count($leaveBalances) > 0)
    <div class="mb-4">
        <h5 class="mb-3">My Leave Balance</h5>
        <div class="row g-3">
            @foreach($leaveBalances as $balance)
            <div class="col-md-6 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="mb-2">
                            <span class="badge bg-primary fs-6">{{ $balance->leaveType->name }}</span>
                        </div>
                        <h3 class="text-primary mb-1">{{ $balance->remaining_leaves }}</h3>
                        <small class="text-muted">days remaining</small>
                        <div class="mt-2">
                            <small class="text-muted">Total: {{ $balance->leaveType->annual_allowed }} days</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type</th>
                            <th>Range</th>
                            <th>Status</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $l)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $l->type->name ?? 'N/A' }}</td>
                            <td>{{ $l->start_date }} — {{ $l->end_date }}</td>
                            <td><span class="badge bg-info">{{ $l->status }}</span></td>
                            <td>{{ $l->reason }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center">No leave requests found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
