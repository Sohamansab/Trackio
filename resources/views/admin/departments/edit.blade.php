@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3>Edit Department</h3>

    <form action="{{ route('admin.departments.update', $department->department_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Department Name</label>
            <input type="text" name="department_name" class="form-control"
                   value="{{ $department->department_name }}" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
