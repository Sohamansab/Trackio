@extends('layouts.admin')

@section('title', 'Edit Attendance')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">Edit Attendance</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.attendance.update', $attendance->attendance_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Employee Selection -->
                    <div class="col-md-6 mb-3">
                        <label for="emp_id" class="form-label">Employee <span class="text-danger">*</span></label>
                        <select name="emp_id" id="emp_id" required class="form-control">
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->emp_id }}" 
                                        {{ old('emp_id', $attendance->emp_id) == $employee->emp_id ? 'selected' : '' }}>
                                    {{ $employee->name }} ({{ $employee->employee_code }})
                                </option>
                            @endforeach
                        </select>
                        @error('emp_id')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="col-md-6 mb-3">
                        <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                        <input type="date" name="date" id="date" required class="form-control"
                               value="{{ old('date', \Carbon\Carbon::parse($attendance->date)->format('Y-m-d')) }}">
                        @error('date')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Check In Time -->
                    <div class="col-md-6 mb-3">
                        <label for="check_in" class="form-label">Check In Time</label>
                        <input type="time" name="check_in" id="check_in" class="form-control"
                               value="{{ old('check_in', $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '') }}">
                        @error('check_in')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Check Out Time -->
                    <div class="col-md-6 mb-3">
                        <label for="check_out" class="form-label">Check Out Time</label>
                        <input type="time" name="check_out" id="check_out" class="form-control"
                               value="{{ old('check_out', $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '') }}">
                        @error('check_out')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <div class="row">
                        @foreach(['Present' => 'Present', 'Absent' => 'Absent', 'Leave' => 'Leave', 'Half-day' => 'Half Day'] as $value => $label)
                            <div class="col-md-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" value="{{ $value }}" 
                                           id="status_{{ $value }}" {{ old('status', $attendance->status) == $value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_{{ $value }}">
                                        {{ $label }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @error('status')
                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Update Attendance</button>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
