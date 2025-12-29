<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OrbitDeviceService
{
    protected $apiUrl;
    protected $apiKey;
    protected $deviceId;
    protected $secretKey;
    protected $timeout;

    public function __construct()
    {
        $this->apiUrl = config('services.orbit.api_url');
        $this->apiKey = config('services.orbit.api_key');
        $this->deviceId = config('services.orbit.device_id');
        $this->secretKey = config('services.orbit.secret_key');
        $this->timeout = config('services.orbit.timeout');
    }

    /**
     * Verify device is connected and working
     */
    public function verifyDevice(): bool
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getHeaders())
                ->get("{$this->apiUrl}/device/status", [
                    'device_id' => $this->deviceId
                ]);

            return $response->successful();
        } catch (Exception $e) {
            Log::error('Orbit Device Verification Failed', [
                'error' => $e->getMessage(),
                'device_id' => $this->deviceId
            ]);
            return false;
        }
    }

    /**
     * Send QR scan data to Orbit device
     */
    public function sendQrScan(array $scanData): array
    {
        try {
            $payload = [
                'device_id' => $this->deviceId,
                'qr_code' => $scanData['qr_code'] ?? null,
                'timestamp' => $scanData['timestamp'] ?? now()->toIso8601String(),
                'type' => $scanData['type'] ?? 'scan',
            ];

            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getHeaders())
                ->post("{$this->apiUrl}/device/scan", $payload);

            if ($response->successful()) {
                Log::info('Orbit QR Scan Success', $payload);
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            Log::warning('Orbit QR Scan Failed', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Orbit device rejected scan'
            ];
        } catch (Exception $e) {
            Log::error('Orbit QR Scan Exception', [
                'error' => $e->getMessage(),
                'scan_data' => $scanData
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Get device configuration
     */
    public function getDeviceConfig(): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getHeaders())
                ->get("{$this->apiUrl}/device/config", [
                    'device_id' => $this->deviceId
                ]);

            return $response->successful() ? $response->json() : [];
        } catch (Exception $e) {
            Log::error('Failed to get Orbit device config', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Update device configuration
     */
    public function updateDeviceConfig(array $config): array
    {
        try {
            $payload = [
                'device_id' => $this->deviceId,
                ...$config
            ];

            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getHeaders())
                ->put("{$this->apiUrl}/device/config", $payload);

            return $response->successful() ? $response->json() : ['success' => false];
        } catch (Exception $e) {
            Log::error('Failed to update Orbit device config', [
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Get recent scans from device
     */
    public function getRecentScans(int $limit = 100): array
    {
        try {
            $response = Http::timeout($this->timeout)
                ->withHeaders($this->getHeaders())
                ->get("{$this->apiUrl}/device/scans", [
                    'device_id' => $this->deviceId,
                    'limit' => $limit
                ]);

            return $response->successful() ? $response->json()['scans'] ?? [] : [];
        } catch (Exception $e) {
            Log::error('Failed to get recent Orbit scans', [
                'error' => $e->getMessage()
            ]);
            return [];
        }
    }

    /**
     * Prepare request headers with authentication
     */
    protected function getHeaders(): array
    {
        return [
            'Authorization' => "Bearer {$this->apiKey}",
            'X-Device-ID' => $this->deviceId,
            'X-Request-Signature' => $this->generateSignature(),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    /**
     * Generate HMAC signature for request
     */
    protected function generateSignature(): string
    {
        $timestamp = now()->timestamp;
        $message = "{$this->deviceId}.{$timestamp}";
        return hash_hmac('sha256', $message, $this->secretKey);
    }

    /**
     * Validate webhook signature from device
     */
    public function validateWebhookSignature(string $signature, array $payload): bool
    {
        $expectedSignature = hash_hmac(
            'sha256',
            json_encode($payload),
            $this->secretKey
        );

        return hash_equals($signature, $expectedSignature);
    }
}
