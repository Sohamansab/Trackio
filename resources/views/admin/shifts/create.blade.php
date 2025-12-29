@extends('layouts.admin')

@section('title', 'Add Shift')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Add New Shift</h4>
        <a href="{{ route('admin.shifts.index') }}" class="btn btn-secondary">
            ← Back to List
        </a>
    </div>

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
            <form action="{{ route('admin.shifts.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="shift_name" class="form-label">Shift Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="shift_name" name="shift_name" 
                               value="{{ old('shift_name') }}" required 
                               placeholder="e.g., Morning Shift, Night Shift">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="grace_minutes" class="form-label">Grace Period (minutes)</label>
                        <input type="number" class="form-control" id="grace_minutes" name="grace_minutes" 
                               value="{{ old('grace_minutes', 0) }}" min="0" max="60"
                               placeholder="e.g., 15">
                        <small class="text-muted">Time allowed after start time before marked late</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_time" class="form-label">Start Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="start_time" name="start_time" 
                               value="{{ old('start_time') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_time" class="form-label">End Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="end_time" name="end_time" 
                               value="{{ old('end_time') }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Create Shift
                    </button>
                    <a href="{{ route('admin.shifts.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

