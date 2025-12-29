<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeProfile;
use App\Services\QrAttendanceService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ScanAttendanceController extends Controller
{
    protected $qrAttendanceService;

    public function __construct(QrAttendanceService $qrAttendanceService)
    {
        $this->qrAttendanceService = $qrAttendanceService;
    }

    public function index()
    {
        return view('admin.scan-attendance');
    }

    public function scan(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        try {
            $result = $this->qrAttendanceService->processQrAttendance($request->qr_code);

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing attendance: ' . $e->getMessage()
            ], 500);
        }
    }
}
