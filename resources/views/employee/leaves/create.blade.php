@extends('layouts.employee')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Apply For Leave</h5>
            <form method="POST" action="{{ route('employee.leaves.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Leave Type</label>
                    <select name="leave_type_id" class="form-select" required>
                        @foreach($types as $t)
                        <option value="{{ $t->leave_type_id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" rows="3"></textarea>
                </div>
                <button class="btn btn-primary">Submit Request</button>
            </form>
        </div>
    </div>
</div>
@endsection
