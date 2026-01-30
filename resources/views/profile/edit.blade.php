@extends($layout)

@section('title', 'Profile Settings')
@section('show_topbar', false)

@section('content')
@if(auth()->user()->role == 1)
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-cog text-primary me-2"></i>Profile Settings</h1>
        <p class="text-muted">Manage your account information and preferences</p>
    </div>

    <!-- Profile Forms -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Update Profile Information -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Update Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-key me-2 text-warning"></i>Update Password
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="card border-0 shadow border-danger">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Danger Zone
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

        <!-- Account Information Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2 text-info"></i>Account Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <p class="mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <p class="mb-0">
                            <span class="badge bg-primary">Admin</span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Last Login</label>
                        <p class="mb-0">{{ auth()->user()->last_login ? \Carbon\Carbon::parse(auth()->user()->last_login)->format('M d, Y H:i') : 'Never' }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Account Status</label>
                        <p class="mb-0">
                            <span class="badge {{ auth()->user()->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@elseif(auth()->user()->role == 0)
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-user-cog text-primary me-2"></i>Profile Settings</h1>
        <p class="text-muted">View your account information and preferences</p>
    </div>

    <!-- Profile Forms -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Update Profile Information -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Update Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card border-0 shadow mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-key me-2 text-warning"></i>Update Password
                    </h5>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Account Information Sidebar -->
        <div class="col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle me-2 text-info"></i>Profile Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <p class="mb-0">{{ auth()->user()->employeeProfile->name ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <p class="mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <p class="mb-0">{{ auth()->user()->employeeProfile->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Department</label>
                        <p class="mb-0">{{ $user->employeeProfile ? ($user->employeeProfile->department->name ?? 'N/A') : 'Not Applicable' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Designation</label>
                        <p class="mb-0">{{ $user->employeeProfile ? ($user->employeeProfile->designation->name ?? 'N/A') : 'Not Applicable' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Shift</label>
                        <p class="mb-0">{{ $user->employeeProfile ? ($user->employeeProfile->shift->name ?? 'N/A') : 'Not Applicable' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Joining Date</label>
                        <p class="mb-0">{{ auth()->user()->employeeProfile->joining_date ? \Carbon\Carbon::parse(auth()->user()->employeeProfile->joining_date)->format('M d, Y') : 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Address</label>
                        <p class="mb-0">{{ auth()->user()->employeeProfile->address ?? 'N/A' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Role</label>
                        <p class="mb-0">
                            <span class="badge bg-primary">Employee</span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Last Login</label>
                        <p class="mb-0">{{ auth()->user()->last_login ? \Carbon\Carbon::parse(auth()->user()->last_login)->format('M d, Y H:i') : 'Never' }}</p>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold">Account Status</label>
                        <p class="mb-0">
                            <span class="badge {{ auth()->user()->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ auth()->user()->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
@endsection

