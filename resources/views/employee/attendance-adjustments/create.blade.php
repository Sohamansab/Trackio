@extends('layouts.employee')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3>Apply for Attendance Adjustment</h3>
        <a href="{{ route('employee.attendance-adjustments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('employee.attendance-adjustments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="adjustment_type" class="form-label">Adjustment Type <span class="text-danger">*</span></label>
                    <select name="adjustment_type" id="adjustment_type" required class="form-select">
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
                    @error('adjustment_type')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="adjustment_date" class="form-label">Adjustment Date <span class="text-danger">*</span></label>
                    <input type="date" name="adjustment_date" id="adjustment_date" required max="{{ date('Y-m-d') }}" class="form-control">
                    @error('adjustment_date')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason <span class="text-danger">*</span></label>
                    <textarea name="reason" id="reason" required minlength="10" class="form-control" rows="4" placeholder="Please provide a detailed reason for your adjustment request..."></textarea>
                    @error('reason')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="attachment" class="form-label">Supporting Document (optional)</label>
                    <input type="file" name="attachment" id="attachment" accept=".pdf,.jpg,.jpeg,.png" class="form-control">
                    <div class="form-text">Accepted formats: PDF, JPG, JPEG, PNG. Max size: 2MB</div>
                    @error('attachment')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('employee.attendance-adjustments.index') }}" class="btn btn-outline-secondary me-md-2">Cancel</a>
                    <button type="submit" class="btn btn-success btn-lg px-4">Submit Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
