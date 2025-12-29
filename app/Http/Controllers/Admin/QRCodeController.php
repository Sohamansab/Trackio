<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeProfile;
use App\Models\QrLog;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function scan(Request $request)
    {
        $employee = EmployeeProfile::where('qr_code', $request->qr_code)->first();

        if (!$employee) {
            return response()->json(['status' => 'error', 'message' => 'Invalid QR'], 404);
        }

        // Log the scan
        QrLog::create([
            'emp_id' => $employee->emp_id,
            'timestamp' => now(),
            'type' => 'ecard-scan'
        ]);

        // Attendance logic
        $today = now()->toDateString();
        $attendance = \App\Models\Attendance::where('emp_id', $employee->emp_id)
            ->where('date', $today)
            ->first();

        if (!$attendance) {
            // First scan: check-in
            $attendance = \App\Models\Attendance::create([
                'emp_id' => $employee->emp_id,
                'date' => $today,
                'check_in' => now()->format('H:i:s'),
                'status' => 'present',
                'source_type' => 'qr',
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Check-in successful',
                'type' => 'check-in',
                'time' => $attendance->check_in
            ]);
        } elseif (is_null($attendance->check_out)) {
            // Second scan: check-out
            $attendance->check_out = now()->format('H:i:s');
            $attendance->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Check-out successful',
                'type' => 'check-out',
                'time' => $attendance->check_out
            ]);
        } else {
            // Already checked out
            return response()->json([
                'status' => 'info',
                'message' => 'Already checked out for today',
                'type' => 'already-checked-out',
                'check_in' => $attendance->check_in,
                'check_out' => $attendance->check_out
            ]);
        }
    }
}
