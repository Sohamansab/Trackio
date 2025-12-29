<?php
namespace App\Http\Controllers;

use App\Models\EmployeeProfile;
use App\Models\QrLog;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicQrController extends Controller
{
    /**
     * Public endpoint for QR scans. Marks attendance and shows times.
     */
    public function show(Request $request, $code)
    {
        $employee = EmployeeProfile::where('qr_code', $code)->first();

        if (! $employee) {
            return view('public.qr_not_found', compact('code'));
        }

        // Log the scan if model exists
        try {
            QrLog::create([
                'emp_id' => $employee->emp_id,
                'timestamp' => now(),
                'type' => 'public-scan',
                'meta' => json_encode(['ip' => $request->ip()])
            ]);
        } catch (\Throwable $e) {
            // Keep going even if logging fails
        }

        $today = Carbon::now()->toDateString();

        $attendance = Attendance::where('emp_id', $employee->emp_id)
            ->where('date', $today)
            ->first();

        $message = null;

        if (! $attendance) {
            // First scan: check-in
            $attendance = new Attendance();
            $attendance->emp_id = $employee->emp_id;
            $attendance->date = $today;
            // store check-in time in app timezone
            $attendance->check_in = Carbon::now()->setTimezone(config('app.timezone'))->format('H:i:s');
            // Use consistent status casing (lowercase)
            $attendance->status = 'present';
            $attendance->source_type = 'qr';
            $attendance->save();

            $message = 'Check-in recorded at ' . $attendance->check_in;
        } elseif (is_null($attendance->check_out)) {
            // Second scan: check-out
            $attendance->check_out = Carbon::now()->format('H:i:s');
            $attendance->save();

            $message = 'Check-out recorded at ' . $attendance->check_out;
        } else {
            $message = 'Already checked out for today';
        }

        return view('public.qr_show', compact('employee', 'attendance', 'message'));
    }
}
