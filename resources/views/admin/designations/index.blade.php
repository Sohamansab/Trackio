@extends('layouts.admin')

@section('title', 'Designations')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">All Designations</h4>
        <a href="{{ route('admin.designations.create') }}" class="btn btn-primary">
            + Add Designation
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
                            <th>Designation Name</th>
                            <th>Employees Count</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($designations as $designation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $designation->designation_name }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $designation->employees->count() }}</span>
                                </td>
                                <td>{{ $designation->created_at ? $designation->created_at->format('d M Y') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.designations.edit', $designation->designation_id) }}" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    
                                    <form action="{{ route('admin.designations.destroy', $designation->designation_id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure? Employees with this designation will be affected.')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No designations found. <a href="{{ route('admin.designations.create') }}">Add one now</a>
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

