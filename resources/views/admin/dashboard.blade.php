@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-chart-line text-primary me-2"></i>Admin Dashboard</h1>
        <p class="text-muted">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
    </div>

    <!-- Today's Attendance Summary Section -->
    <div class="mb-5">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Today's Attendance Summary - {{ \Carbon\Carbon::now()->format('l, d F Y') }}</h3>
        <div class="row g-4">
            <!-- Total Employees Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(255, 255, 255, 0.15);">
                            <i class="fas fa-users"></i>
                        </div>
                        <p class="text-white small text-uppercase tracking-wide fw-semibold">Total Employees</p>
                        <h2 class="text-white fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['total_employees'] ?? 0 }}</h2>
                        <small class="text-white-50">active employees</small>
                    </div>
                </div>
            </div>

            <!-- Working Days Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(14, 165, 233, 0.15);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Working Days</p>
                        <h2 class="text-info fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['working_days'] ?? 0 }}</h2>
                        <small class="text-muted">this month</small>
                    </div>
                </div>
            </div>

            <!-- Pending Leaves Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fef3d4 0%, #fdd97b 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(234, 179, 8, 0.15);">
                            <i class="fas fa-clock"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Pending Leaves</p>
                        <h2 class="text-warning fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['pending_leaves'] ?? 0 }}</h2>
                        <small class="text-muted">awaiting approval</small>
                    </div>
                </div>
            </div>

            <!-- Late Today Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(239, 68, 68, 0.15);">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Late Today</p>
                        <h2 class="text-danger fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['late_today'] ?? 0 }}</h2>
                        <small class="text-muted">employees arrived late</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row -->
        <div class="row g-4 mt-2">
            <!-- Total Present Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #d4f8d4 0%, #b3e5b3 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(34, 197, 94, 0.15);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Total Present</p>
                        <h2 class="text-success fw-bold" style="font-size: 2rem;">{{ $monthlySummary['total_present'] ?? 0 }}</h2>
                        <small class="text-muted">marked present</small>
                    </div>
                </div>
            </div>

            <!-- Total Absent Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fdd4d4 0%, #f5b3b3 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(239, 68, 68, 0.15);">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Total Absent</p>
                        <h2 class="text-danger fw-bold" style="font-size: 2rem;">{{ $monthlySummary['total_absent'] ?? 0 }}</h2>
                        <small class="text-muted">including unmarked</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Attendance Records Section -->
    <div class="card border-0 shadow">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);" class="card-header border-0">
            <h5 class="text-white fw-bold mb-0">
                <i class="fas fa-list me-2"></i>Recent Attendance Records
            </h5>
        </div>

        <div class="card-body">
            @if(empty($recentAttendance) || count($recentAttendance) === 0)
                <div class="text-center py-5">
                    <i class="fas fa-inbox text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                    <p class="text-muted mt-3">No attendance records found</p>
                    <small class="text-muted">Attendance records will appear here</small>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold text-gray-700">
                                    <i class="fas fa-user me-2 text-primary"></i>Employee
                                </th>
                                <th class="fw-bold text-gray-700">
                                    <i class="fas fa-calendar me-2 text-primary"></i>Date
                                </th>
                                <th class="fw-bold text-gray-700">
                                    <i class="fas fa-sign-in-alt me-2 text-success"></i>Check In
                                </th>
                                <th class="fw-bold text-gray-700">
                                    <i class="fas fa-sign-out-alt me-2 text-danger"></i>Check Out
                                </th>
                                <th class="fw-bold text-gray-700">
                                    <i class="fas fa-badge-check me-2 text-info"></i>Status
                                </th>
                                <th class="fw-bold text-gray-700">
                                    <i class="fas fa-source me-2 text-warning"></i>Source
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendance as $record)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-3" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: bold;">
                                                {{ substr($record->employee->user->name ?? 'N/A', 0, 1) }}
                                            </div>
                                            <div>
                                                <strong>{{ $record->employee->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $record->employee->emp_id ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($record->date)->format('d M Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($record->date)->format('l') }}</small>
                                    </td>
                                    <td>
                                        @if($record->check_in)
                                            @php
                                                // Assuming employee shift can be accessed. Default to 'morning' if not set.
                                                $shiftName = $record->employee->shift->name ?? 'morning';
                                                $statusDetails = app(App\Services\AttendanceService::class)->determineAttendanceStatus($shiftName, $record->check_in, $record->check_out);
                                            @endphp
                                            <div>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>
                                                    {{ \Carbon\Carbon::parse($record->check_in)->format('H:i') }}
                                                </span>
                                                @if($statusDetails['check_in_status'] === 'Late')
                                                    <span class="badge bg-warning text-dark ms-1" title="{{ $statusDetails['minutes_late'] }} minutes late">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Late
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->check_out)
                                            <div>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>
                                                    {{ \Carbon\Carbon::parse($record->check_out)->format('H:i') }}
                                                </span>
                                                @if($statusDetails['early_checkout'])
                                                    <span class="badge bg-info text-dark ms-1" title="{{ $statusDetails['minutes_early'] }} minutes early">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Early
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusBadge = match($record->status) {
                                                'present' => ['bg-success', 'Present', 'fa-check-circle'],
                                                'late' => ['bg-warning text-dark', 'Late', 'fa-exclamation-triangle'],
                                                'absent' => ['bg-danger', 'Absent', 'fa-times-circle'],
                                                'leave' => ['bg-warning', 'Leave', 'fa-calendar'],
                                                'half-day' => ['bg-info', 'Half Day', 'fa-hourglass-half'],
                                                default => ['bg-secondary', ucfirst($record->status), 'fa-dot-circle']
                                            };
                                        @endphp
                                        <span class="badge {{ $statusBadge[0] }}">
                                            <i class="fas {{ $statusBadge[2] }} me-1"></i>
                                            {{ $statusBadge[1] }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $sourceIcon = match($record->source_type) {
                                                'qr' => 'fa-qrcode',
                                                'biometric' => 'fa-fingerprint',
                                                'manual' => 'fa-keyboard',
                                                default => 'fa-dot-circle'
                                            };
                                        @endphp
                                        <span class="text-muted small">
                                            <i class="fas {{ $sourceIcon }} me-1"></i>
                                            {{ ucfirst($record->source_type) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No attendance records found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .tracking-wide {
        letter-spacing: 0.05em;
    }
    .page-header {
        margin-bottom: 2rem;
    }
</style>
@endsection
