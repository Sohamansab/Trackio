@extends('layouts.admin')

@section('title', 'Shifts')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All Shifts</h4>
        <a href="{{ route('admin.shifts.create') }}" class="btn btn-primary">
            + Add Shift
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
                            <th>Shift Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Grace Period</th>
                            <th>Employees</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shifts as $shift)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $shift->shift_name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-danger">{{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</span>
                                </td>
                                <td>{{ $shift->grace_minutes }} minutes</td>
                                <td>
                                    <span class="badge bg-info">{{ $shift->employees->count() }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.shifts.edit', $shift->shift_id) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    
                                    <form action="{{ route('admin.shifts.destroy', $shift->shift_id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure? Employees with this shift will be affected.')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    No shifts found. <a href="{{ route('admin.shifts.create') }}">Add one now</a>
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

