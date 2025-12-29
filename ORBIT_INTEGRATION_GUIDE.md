# Orbit QR Device Integration Guide

## Overview
This guide explains how to integrate your Orbit QR card scanning device with the Trackio attendance system.

## Prerequisites
- Orbit device IP address and network access
- Orbit API credentials (API Key, Secret Key, Device ID)
- Device connected to the same network as your server (or accessible via internet)

## Installation Steps

### 1. Configure Environment Variables
Add these variables to your `.env` file:

```env
ORBIT_ENABLED=true
ORBIT_API_URL=http://192.168.1.100:8080/api
ORBIT_API_KEY=your_api_key_from_orbit
ORBIT_DEVICE_ID=your_device_id
ORBIT_SECRET_KEY=your_secret_key
ORBIT_TIMEOUT=30
```

**Where to get these values:**
- `ORBIT_API_URL`: Your Orbit device IP and port (check device manual)
- `ORBIT_API_KEY`: Generated from Orbit device admin panel
- `ORBIT_DEVICE_ID`: Unique identifier for your device
- `ORBIT_SECRET_KEY`: Shared secret for webhook signature validation

### 2. Database Migrations
Your database already has tables configured:
- `qr_cards` - Stores employee QR codes
- `qr_logs` - Logs all QR scan events
- `attendance` - Records attendance with `source_type = 'qr'`

No additional migrations needed.

### 3. API Endpoints Created

#### a) POST `/api/qr-scan`
**Primary endpoint** - Receives scan data from device
```bash
curl -X POST http://localhost/api/qr-scan \
  -H "Content-Type: application/json" \
  -d {
    "qr_code": "EMP001",
    "device_id": "orbit_001",
    "timestamp": "2025-12-05T10:30:00Z"
  }
```

**Response:**
```json
{
  "status": "success",
  "employee": {
    "emp_id": 1,
    "name": "John Doe",
    "department": "Sales"
  },
  "attendance": {
    "success": true,
    "message": "Check-in recorded successfully",
    "scan_type": "check-in",
    "time": "2025-12-05T10:30:00Z",
    "status": "on-time"
  }
}
```

#### b) POST `/api/qr-webhook`
**Webhook endpoint** - For Orbit device callbacks
- Validates webhook signature
- Handles multiple event types (scan, device_status, error)
- Automatically processes scans

#### c) GET `/api/qr-device-status`
**Status check** - Verify device connection
```bash
curl http://localhost/api/qr-device-status
```

### 4. Configuring Orbit Device

#### Network Setup
1. Access Orbit device admin panel (usually at device IP)
2. Navigate to Network settings
3. Configure:
   - IP Address: Static IP recommended
   - Gateway: Your router gateway
   - DNS: 8.8.8.8 or your network DNS

#### API Configuration
1. Go to Device Settings → API
2. Enable API access
3. Set API Key (use value in `ORBIT_API_KEY`)
4. Configure webhook URL: `http://your-server.com/api/qr-webhook`
5. Set webhook events: "scan", "device_status", "error"
6. Enable HTTPS if available

#### QR Code Scanning Settings
1. Settings → QR Scanner
2. Set scan timeout: 5000ms (5 seconds)
3. Enable beep on scan (optional)
4. Set display message: "✓ Scan Complete"

### 5. Employee QR Codes Setup

Before scanning, ensure employees have QR codes assigned:

```php
// In EmployeeProfile seeder or controller
$employee->update([
    'qr_code' => 'EMP001', // Unique code for each employee
]);
```

Or generate dynamically:
```php
$employee->qr_code = 'EMP' . str_pad($employee->emp_id, 4, '0', STR_PAD_LEFT);
$employee->save();
```

### 6. Testing the Integration

#### Test 1: Check Device Connection
```bash
GET /api/qr-device-status
```
Expected: `{"connected": true, "device_id": "orbit_001", ...}`

#### Test 2: Simulate QR Scan
```bash
curl -X POST http://localhost/api/qr-scan \
  -H "Content-Type: application/json" \
  -d '{
    "qr_code": "EMP001",
    "device_id": "orbit_001",
    "timestamp": "2025-12-05T10:30:00Z"
  }'
```

#### Test 3: Check Attendance Record
```sql
SELECT * FROM attendance WHERE emp_id = 1 AND date = CURDATE();
SELECT * FROM qr_logs WHERE emp_id = 1 ORDER BY created_at DESC;
```

### 7. Monitoring & Troubleshooting

#### Check Logs
```bash
tail -f storage/logs/laravel.log
```

Look for:
- "Orbit Device Verification Failed" - Connection issue
- "Invalid QR Code Scanned" - QR code not found
- "QR Check-in Recorded" - Successful scan

#### Common Issues

**Issue: Device not connecting**
- Verify device IP in `ORBIT_API_URL`
- Check firewall allows communication
- Verify API key and device ID
- Check device is powered on and network connected

**Issue: Scans not recorded**
- Verify employee has QR code assigned
- Check `ORBIT_ENABLED=true` in .env
- Verify webhook URL is accessible from device
- Check webhook signature validation

**Issue: Webhook signature invalid**
- Ensure `ORBIT_SECRET_KEY` matches device
- Verify device is sending correct headers
- Check timestamp synchronization between device and server

#### Enable Debug Mode
Add to `.env`:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

### 8. File Structure
```
app/
├── Services/
│   ├── OrbitDeviceService.php       # Device communication
│   └── QrAttendanceService.php      # Attendance recording
├── Http/Controllers/Admin/
│   ├── QRCodeController.php         # QR scanning logic
│   └── OrbitDeviceController.php    # Device management
└── Models/
    ├── QrCard.php
    ├── QrLog.php
    └── Attendance.php

config/
└── services.php                      # Device configuration

routes/
└── api.php                          # API endpoints
```

### 9. Workflow

1. Employee scans QR card on Orbit device
2. Device captures QR code and sends to `/api/qr-scan` or webhook
3. Controller finds employee by QR code
4. Logs the scan in `qr_logs` table
5. Records attendance:
   - **First scan** = Check-in (stored with check_in time, status=on-time/late)
   - **Second scan** = Check-out (updates same record)
   - **Third+ scan** = Ignored
6. Returns response to device (optional display message)
7. Device displays confirmation message

### 10. Advanced Configuration

#### Grace Period for Late Arrival
Configure in shift settings:
```php
$shift->grace_time = 5; // 5 minutes grace period
```

#### Custom Status Logic
Modify `QrAttendanceService::determineStatus()` for your business rules

#### Webhook Security
Secrets are auto-generated using HMAC-SHA256. Never share `ORBIT_SECRET_KEY`.

## Support

For issues or questions:
1. Check `storage/logs/laravel.log` for errors
2. Verify device API documentation
3. Test endpoint connectivity with Postman
4. Check network connectivity with `ping device_ip`

## Notes
- Ensure server time is synchronized (NTP)
- Use HTTPS in production for webhook endpoint
- Implement rate limiting for `/api/qr-scan` in production
- Regular backups of attendance data recommended
