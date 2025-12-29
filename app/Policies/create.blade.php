@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Request Attendance Adjustment</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('employee.attendance-adjustments.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="adjustment_type" class="form-label">Adjustment Type</label>
                            <select name="adjustment_type" id="adjustment_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="Absent Adjustment">Absent Adjustment</option>
                                <option value="Late In Adjustment">Late In Adjustment</option>
                                <option value="Early Going Adjustment">Early Going Adjustment</option>
                                <option value="Forgot to Mark Attendance">Forgot to Mark Attendance</option>
                                <option value="Forgot Attendance Card">Forgot Attendance Card</option>
                                <option value="Full Day Compensation">Full Day Compensation</option>
                                <option value="Outdoor Absent Adjustment">Outdoor Absent Adjustment</option>
                                <option value="System Out Adjustment">System Out Adjustment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="adjustment_date" class="form-label">Date</label>
                            <input type="date" name="adjustment_date" id="adjustment_date" class="form-control" max="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason</label>
                            <textarea name="reason" id="reason" class="form-control" rows="3" required minlength="10"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="attachment" class="form-label">Attachment (Optional)</label>
                            <input type="file" name="attachment" id="attachment" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection