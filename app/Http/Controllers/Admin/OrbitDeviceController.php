<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrbitDeviceService;
use Illuminate\Http\Request;

class OrbitDeviceController extends Controller
{
    protected $orbitService;

    public function __construct(OrbitDeviceService $orbitService)
    {
        $this->orbitService = $orbitService;
    }

    /**
     * Check device connection and status
     */
    public function status()
    {
        $isConnected = $this->orbitService->verifyDevice();
        $config = $this->orbitService->getDeviceConfig();

        return view('admin.orbit-device.status', [
            'connected' => $isConnected,
            'config' => $config,
            'device_id' => config('services.orbit.device_id'),
        ]);
    }

    /**
     * Get recent scans
     */
    public function recentScans(Request $request)
    {
        $limit = $request->query('limit', 100);
        $scans = $this->orbitService->getRecentScans($limit);

        return view('admin.orbit-device.scans', [
            'scans' => $scans,
        ]);
    }

    /**
     * Update device configuration
     */
    public function updateConfig(Request $request)
    {
        $config = $request->validate([
            'beep_on_scan' => 'boolean',
            'display_message' => 'string|max:255',
            'scan_timeout' => 'integer|min:1|max:300',
        ]);

        $result = $this->orbitService->updateDeviceConfig($config);

        if ($result['success'] ?? false) {
            return back()->with('success', 'Device configuration updated successfully');
        }

        return back()->with('error', 'Failed to update device configuration');
    }

    /**
     * Test device connectivity
     */
    public function testConnection()
    {
        $isConnected = $this->orbitService->verifyDevice();

        return response()->json([
            'connected' => $isConnected,
            'device_id' => config('services.orbit.device_id'),
            'message' => $isConnected ? 'Device is connected' : 'Device connection failed'
        ]);
    }
}
