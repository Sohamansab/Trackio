@extends('layouts.employee')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard-stats.css') }}">
@endpush

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-chart-line text-primary me-2"></i>Employee Dashboard</h1>
        {{-- The $today variable should be passed from the controller --}}
        {{-- <p class="text-muted">{{ $today->format('l, d F Y') }}</p> --}}
        {{-- <p class="text-muted">{{ $today->format('l, d F Y') }}</p> --}}
    </div>

    <!-- Today's Status Section -->
    <div class="mb-5">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Today's Status</h3>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                @if($todaysStatus['status'] === 'Late')
                    <div class="d-flex align-items-center">
                        <div class="me-4 text-danger" style="font-size: 3rem;">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-danger mb-1">You are Late</h4>
                            <p class="mb-1">You checked in at <strong>{{ $todaysStatus['check_in'] }}</strong>, which was {{ $todaysStatus['details']['minutes_late'] }} minutes late.</p>
                            <small class="text-muted">Please ensure you check in on time for your shift.</small>
                        </div>
                    </div>
                @elseif($todaysStatus['status'] === 'On Time')
                    <div class="d-flex align-items-center">
                        <div class="me-4 text-success" style="font-size: 3rem;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-success mb-1">You are On Time</h4>
                            <p class="mb-1">You checked in at <strong>{{ $todaysStatus['check_in'] }}</strong>. Great job!</p>
                            <small class="text-muted">Keep up the excellent punctuality.</small>
                        </div>
                    </div>
                @else
                    <div class="d-flex align-items-center">
                        <div class="me-4 text-secondary" style="font-size: 3rem;">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-secondary mb-1">Attendance Not Marked</h4>
                            <p class="mb-0">Your attendance for today has not been recorded yet.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Attendance Chart -->
    <div class="mb-5">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light border-0">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-chart-bar me-2 text-primary"></i>Monthly Overview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div style="height: 300px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Attendance Summary Section -->
    <div class="mb-5">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Monthly Attendance Summary - {{ $monthName ?? 'This Month' }}</h3>
        <div class="row g-4">
            <!-- Working Days Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #cce7ff 0%, #a8d5ff 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(13, 110, 253, 0.15);">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Working Days</p>
                        <h2 class="text-primary fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['total_working_days'] ?? 0 }}</h2>
                        <small class="text-muted">in month</small>
                    </div>
                </div>
            </div>

            <!-- Present Days Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #d4f8d4 0%, #b3e5b3 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(34, 197, 94, 0.15);">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Present Days</p>
                        <h2 class="text-success fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['total_present'] ?? 0 }}</h2>
                        <small class="text-muted">marked present</small>
                    </div>
                </div>
            </div>

            <!-- Absent Days Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fdd4d4 0%, #f5b3b3 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(239, 68, 68, 0.15);">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Absent Days</p>
                        <h2 class="text-danger fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['total_absent'] ?? 0 }}</h2>
                        <small class="text-muted">including unmarked</small>
                    </div>
                </div>
            </div>

            <!-- Leave Days Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fef3d4 0%, #fdd97b 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 5rem; color: rgba(234, 179, 8, 0.15);">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Leave Days</p>
                        <h2 class="text-warning fw-bold" style="font-size: 2.5rem;">{{ $monthlySummary['total_leave'] ?? 0 }}</h2>
                        <small class="text-muted">approved leaves</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats Row -->
        <div class="row g-4 mt-2">
            <!-- Attendance Percentage Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(147, 51, 234, 0.15);">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Attendance Percentage</p>
                        <h2 class="text-primary fw-bold" style="font-size: 2rem;">{{ $monthlySummary['attendance_percentage'] ?? 0 }}%</h2>
                        <small class="text-muted">based on present days</small>
                    </div>
                </div>
            </div>

            <!-- Half Days Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);">
                    <div class="card-body position-relative">
                        <div style="position: absolute; top: -20px; right: -20px; font-size: 4rem; color: rgba(245, 158, 11, 0.15);">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <p class="text-muted small text-uppercase tracking-wide fw-semibold">Half Days</p>
                        <h2 class="text-warning fw-bold" style="font-size: 2rem;">{{ $monthlySummary['total_half_day'] ?? 0 }}</h2>
                        <small class="text-muted">half day attendance</small>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Recent Attendance Records Section -->
    <div class="card border-0 shadow">
        <div class="card-header bg-light border-0">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-history me-2 text-primary"></i>My Recent Attendance
            </h5>
        </div>

        <div class="card-body">
            @if($recentAttendance->isEmpty())
                <div class="text-center py-5">
                    <p class="text-muted">No recent attendance records found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-bold">Date</th>
                                <th class="fw-bold">Check In</th>
                                <th class="fw-bold">Check Out</th>
                                <th class="fw-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentAttendance as $record)
                                <tr>
                                    <td>
                                        <strong>{{ $record->date->format('d M Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $record->date->format('l') }}</small>
                                    </td>
                                    <td>
                                        @if($record->check_in)
                                            <div>
                                                <span class="badge bg-success">{{ $record->check_in->format('H:i') }}</span>
                                                @if($record->check_in_status === 'Late')
                                                    <span class="badge bg-warning text-dark ms-1" title="{{ $record->minutes_late }} minutes late">Late</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($record->check_out)
                                            <div>
                                                <span class="badge bg-danger">{{ $record->check_out->format('H:i') }}</span>
                                                @if($record->early_checkout)
                                                    <span class="badge bg-info text-dark ms-1" title="{{ $record->minutes_early }} minutes early">Early</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusBadge = match($record->status) {
                                                'present' => ['bg-success', 'Present'],
                                                'late' => ['bg-warning text-dark', 'Late'],
                                                'absent' => ['bg-danger', 'Absent'],
                                                'leave' => ['bg-info', 'Leave'],
                                                'half-day' => ['bg-primary', 'Half Day'],
                                                default => ['bg-secondary', ucfirst($record->status)]
                                            };
                                        @endphp
                                        <span class="badge {{ $statusBadge[0] }}">{{ $statusBadge[1] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Include Chart.js library -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the chart data from PHP
        const chartData = @json($chartData ?? []);

        const ctx = document.getElementById('attendanceChart');
        if (ctx && chartData.length > 0) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.map(day => day.day),
                    datasets: [{
                        label: 'Attendance',
                        data: chartData.map(day => day.value),
                        backgroundColor: chartData.map(day => day.color),
                        borderColor: chartData.map(day => day.color.replace('0.6', '1').replace('0.5', '1').replace('0.25', '1').replace('0.75', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    const day = chartData[context[0].dataIndex];
                                    return day.day_name + ', ' + day.date;
                                },
                                label: function(context) {
                                    const day = chartData[context.dataIndex];
                                    let label = day.status.replace('_', ' ').toUpperCase();
                                    if (day.check_in) {
                                        label += '\nCheck-in: ' + day.check_in;
                                    }
                                    if (day.check_out) {
                                        label += '\nCheck-out: ' + day.check_out;
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Day of Month'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 0.25,
                                callback: function(value) {
                                    switch(value) {
                                        case 0: return 'No Data';
                                        case 0.25: return 'Absent';
                                        case 0.5: return 'Half Day';
                                        case 0.75: return 'Leave';
                                        case 1: return 'Present';
                                        default: return '';
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
@endsection
