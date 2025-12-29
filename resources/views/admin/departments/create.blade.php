@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <h3>Add Department</h3>

    <form action="{{ route('admin.departments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Department Name</label>
            <input type="text" name="department_name" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-secondary">Back</a>
    </form>

</div>
@endsection
