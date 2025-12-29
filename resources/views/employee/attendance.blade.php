@extends('layouts.employee')

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-header mb-5">
        <h1><i class="fas fa-calendar-check text-primary me-2"></i>Today's Attendance</h1>
        <p class="text-muted">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</p>
    </div>

    @if($attendance)
            <!-- Attendance Card -->
        <div class="card border-0 shadow mb-4">
            <div class="card-body">
                <!-- Status Badge -->
                <div class="mb-4">
                    @if($attendance->check_in && $attendance->check_out)
                        <span class="badge bg-success py-2 px-3">
                            <i class="fas fa-check-circle me-2"></i>
                            Completed Today
                        </span>
                    @elseif($attendance->check_in)
                        <span class="badge bg-info py-2 px-3">
                            <i class="fas fa-clock me-2"></i>
                            Checked In
                        </span>
                    @else
                        <span class="badge bg-warning py-2 px-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Not Checked In
                        </span>
                    @endif
                </div>

                <!-- Time Details Grid -->
                <div class="row g-4 mb-4 pb-4 border-bottom">
                    <!-- Check-in -->
                    <div class="col-md-6">
                        <div class="text-center p-4" style="background: linear-gradient(135deg, #d4e0f7 0%, #b3cce0 100%); border-radius: 12px;">
                            <p class="text-muted small text-uppercase fw-semibold">Check-In Time</p>
                            <div class="mt-3">
                                @if($attendance->check_in)
                                    <p class="text-info fw-bold" style="font-size: 2.5rem;">
                                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                                    </p>
                                    <p class="text-muted small mt-2">
                                        {{ \Carbon\Carbon::parse($attendance->check_in)->format('A') }}
                                    </p>
                                @else
                                    <p class="text-muted fw-bold" style="font-size: 2.5rem;">—</p>
                                    <p class="text-muted small mt-2">Not checked in</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Check-out -->
                    <div class="col-md-6">
                        <div class="text-center p-4" style="background: linear-gradient(135deg, #fdd4d4 0%, #f5b3b3 100%); border-radius: 12px;">
                            <p class="text-muted small text-uppercase fw-semibold">Check-Out Time</p>
                            <div class="mt-3">
                                @if($attendance->check_out)
                                    <p class="text-danger fw-bold" style="font-size: 2.5rem;">
                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                                    </p>
                                    <p class="text-muted small mt-2">
                                        {{ \Carbon\Carbon::parse($attendance->check_out)->format('A') }}
                                    </p>
                                @else
                                    <p class="text-muted fw-bold" style="font-size: 2.5rem;">—</p>
                                    <p class="text-muted small mt-2">Not checked out</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Duration & Status -->
                @if($attendance->check_in && $attendance->check_out)
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="text-muted small text-uppercase fw-semibold">Working Duration</p>
                            <p class="fw-bold" style="font-size: 1.5rem;">
                                @php
                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                    $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                    $totalMinutes = $checkIn->diffInMinutes($checkOut);
                                    $hours = floor($totalMinutes / 60);
                                    $minutes = $totalMinutes % 60;
                                @endphp
                                {{ $hours }}h {{ $minutes }}m
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="text-muted small text-uppercase fw-semibold">Attendance Status</p>
                            <p class="text-success fw-bold" style="font-size: 1.5rem;">
                                <i class="fas fa-check-circle"></i> Present
                            </p>
                        </div>
                    </div>
                @else
                    <div class="alert alert-info mb-0">
                        <p class="mb-0">
                            @if(!$attendance->check_in)
                                <i class="fas fa-info-circle me-2"></i>
                                You haven't checked in today yet. Please scan your QR code or use the scan form.
                            @else
                                <i class="fas fa-info-circle me-2"></i>
                                You have checked in but not yet checked out. See you at the end of your shift!
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>

                <!-- Action Buttons -->
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('employee.qr.show') }}" class="btn btn-primary">
                <i class="fas fa-qrcode me-2"></i>
                View QR Card
            </a>
        </div>
        @else
            <!-- No Attendance Alert -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg p-8 text-center">
                <div class="mb-4">
                    <i class="fas fa-inbox text-6xl text-gray-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Attendance Marked</h3>
                <p class="text-gray-600 mb-6">You haven't checked in today. Please scan your QR code or use the scan form to mark your attendance.</p>
                
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('employee.qr.show') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:shadow-lg transition-all">
                        <i class="fas fa-qrcode"></i>
                        View My QR
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
