<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceAdjustmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role == 1) {
        return redirect()->route('admin.dashboard');
    } elseif (Auth::user()->role == 0) {
        return redirect()->route('employee.dashboard');
    }
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('attendance', \App\Http\Controllers\Admin\AttendanceController::class);
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
    Route::resource('shifts', \App\Http\Controllers\Admin\ShiftController::class);
    Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
    Route::resource('designations', \App\Http\Controllers\Admin\DesignationController::class);
    Route::resource('leave-types', \App\Http\Controllers\Admin\LeaveTypeController::class);
    Route::resource('leaves', \App\Http\Controllers\Admin\LeaveController::class);
    // Approve/reject routes (resource will provide index/show/create/store)
    Route::post('leaves/{leave}/approve', [\App\Http\Controllers\Admin\LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{leave}/reject', [\App\Http\Controllers\Admin\LeaveController::class, 'reject'])->name('leaves.reject');

    // Attendance Adjustments
    Route::get('attendance-adjustments', [AttendanceAdjustmentController::class, 'adminIndex'])->name('attendance-adjustments.index');
    Route::get('attendance-adjustments/{id}', [AttendanceAdjustmentController::class, 'show'])->name('attendance-adjustments.show');
    Route::post('attendance-adjustments/{id}/approve', [AttendanceAdjustmentController::class, 'approve'])->name('attendance-adjustments.approve');
    Route::post('attendance-adjustments/{id}/reject', [AttendanceAdjustmentController::class, 'reject'])->name('attendance-adjustments.reject');

    // QR code generation and display
    Route::get('employee/{emp_id}/qr/generate', [\App\Http\Controllers\Admin\EmployeeQrController::class, 'generate'])->name('employee.qr.generate');
    Route::get('employee/{emp_id}/qr', [\App\Http\Controllers\Admin\EmployeeQrController::class, 'show'])->name('employee.qr.show');

    // Scan attendance routes
    Route::get('scan-attendance', [\App\Http\Controllers\Admin\ScanAttendanceController::class, 'index'])->name('scan-attendance');
    Route::post('scan-attendance/scan', [\App\Http\Controllers\Admin\ScanAttendanceController::class, 'scan'])->name('scan-attendance.scan');
});


// Attendance scan form (open to all, or restrict as needed)
Route::get('/attendance/scan', function() {
    return view('attendance.scan');
})->name('attendance.scan.form');
Route::post('/attendance/scan', [\App\Http\Controllers\AttendanceController::class, 'scan'])->name('attendance.scan');

// Public QR endpoint (no auth) — scanner/device can open this URL
Route::get('/qr/{code}', [\App\Http\Controllers\PublicQrController::class, 'show'])->name('public.qr.show');

// Employee routes

// This route is for creating a profile, so it should NOT have the 'employee.profile' middleware
Route::middleware(['auth', 'employee'])->group(function() {
    // You will need to create this controller and view
    Route::get('employee/profile/create', [\App\Http\Controllers\Employee\ProfileController::class, 'create'])->name('employee.profile.create');
    Route::post('employee/profile', [\App\Http\Controllers\Employee\ProfileController::class, 'store'])->name('employee.profile.store');
});

Route::middleware(['auth', 'employee', 'employee.profile'])->prefix('employee')->name('employee.')->group(function() {
    Route::get('dashboard', [\App\Http\Controllers\Employee\DashboardController::class, 'index'])->name('dashboard');
    Route::get('attendance/today', [\App\Http\Controllers\Employee\AttendanceController::class, 'today'])->name('attendance.today');
        // Employee QR view
        Route::get('qr', [\App\Http\Controllers\Employee\EmployeeQrController::class, 'show'])->name('qr.show');
    // Employee leave routes
    Route::get('leaves', [\App\Http\Controllers\Employee\LeaveController::class, 'index'])->name('leaves.index');
    Route::get('leaves/create', [\App\Http\Controllers\Employee\LeaveController::class, 'create'])->name('leaves.create');
    Route::post('leaves', [\App\Http\Controllers\Employee\LeaveController::class, 'store'])->name('leaves.store');

    // Attendance Adjustments
    Route::get('attendance-adjustments/create', [AttendanceAdjustmentController::class, 'create'])->name('attendance-adjustments.create');
    Route::post('attendance-adjustments', [AttendanceAdjustmentController::class, 'store'])->name('attendance-adjustments.store');
    Route::get('attendance-adjustments', [AttendanceAdjustmentController::class, 'index'])->name('attendance-adjustments.index');

});


require __DIR__.'/auth.php';
