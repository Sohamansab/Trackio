@extends('layouts.admin')

@section('title', 'Edit Designation')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit Designation</h4>
        <a href="{{ route('admin.designations.index') }}" class="btn btn-secondary">
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
            <form action="{{ route('admin.designations.update', $designation->designation_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="designation_name" class="form-label">Designation Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="designation_name" name="designation_name" 
                               value="{{ old('designation_name', $designation->designation_name) }}" required>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        Update Designation
                    </button>
                    <a href="{{ route('admin.designations.index') }}" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

