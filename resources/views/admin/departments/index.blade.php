@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Departments</h3>
        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">+ Add Department</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Department Name</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach($departments as $dept)
            <tr>
                <td>{{ $dept->department_id }}</td>
                <td>{{ $dept->department_name }}</td>
                <td>
                    <a href="{{ route('admin.departments.edit', $dept->department_id) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                    <form action="{{ route('admin.departments.destroy', $dept->department_id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this department?')">
                            Delete
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
