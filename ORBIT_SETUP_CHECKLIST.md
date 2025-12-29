# Orbit Integration Checklist

## Pre-Integration Setup
- [ ] Obtain Orbit device IP address from IT/Network team
- [ ] Request API credentials from Orbit (API Key, Secret Key)
- [ ] Get Device ID from device sticker/admin panel
- [ ] Ensure device is connected to network
- [ ] Ensure device is accessible from your server

## Laravel Application Setup
- [ ] Add environment variables to `.env` (see `.env.orbit.example`)
- [ ] Verify `config/services.php` has Orbit configuration
- [ ] Review `app/Services/OrbitDeviceService.php` (handles API calls)
- [ ] Review `app/Services/QrAttendanceService.php` (handles attendance logic)
- [ ] Review updated `app/Http/Controllers/Admin/QRCodeController.php`
- [ ] Check routes in `routes/api.php`

## Employee Setup
- [ ] Ensure all employees have QR codes assigned
- [ ] QR codes must be unique per employee
- [ ] Format: `EMP001`, `EMP002`, etc. (or your format)
- [ ] Store QR code in `EmployeeProfile.qr_code` field

## Device Configuration
- [ ] Access device admin panel
- [ ] Configure API endpoint: `/api/qr-scan`
- [ ] Set API Key (from your .env)
- [ ] Configure webhook URL: `http://your-server/api/qr-webhook`
- [ ] Enable webhook for events: scan, device_status, error
- [ ] Set QR scanner timeout: 5000ms
- [ ] Test device connectivity

## Testing
- [ ] Test endpoint: `GET /api/qr-device-status` (should return connected=true)
- [ ] Test QR scan with Postman to `/api/qr-scan`
- [ ] Verify attendance record created in database
- [ ] Check QR log entry in `qr_logs` table
- [ ] Test check-in and check-out flow
- [ ] Verify webhook signature validation works
- [ ] Check logs for errors: `storage/logs/laravel.log`

## Production Deployment
- [ ] Set `ORBIT_ENABLED=true` in production .env
- [ ] Use HTTPS for webhook URL
- [ ] Implement rate limiting on `/api/qr-scan`
- [ ] Set up monitoring/alerting for device disconnection
- [ ] Configure log rotation for attendance logs
- [ ] Create database backups schedule
- [ ] Document device access credentials (secure storage)
- [ ] Train staff on device operation

## Troubleshooting Commands

```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Test device connectivity
curl http://your-server/api/qr-device-status

# Simulate QR scan
curl -X POST http://your-server/api/qr-scan \
  -H "Content-Type: application/json" \
  -d '{"qr_code":"EMP001"}'

# Check attendance records
php artisan tinker
> App\Models\Attendance::where('date', today())->get()
> App\Models\QrLog::latest()->take(10)->get()
```

## Quick Reference

**Environment Variables Location:** `.env`

**Key Files:**
- Services: `app/Services/OrbitDeviceService.php`, `app/Services/QrAttendanceService.php`
- Controller: `app/Http/Controllers/Admin/QRCodeController.php`
- Routes: `routes/api.php`
- Config: `config/services.php`
- Guide: `ORBIT_INTEGRATION_GUIDE.md`

**API Endpoints:**
- `POST /api/qr-scan` - Main scanning endpoint
- `POST /api/qr-webhook` - Webhook receiver
- `GET /api/qr-device-status` - Status check

**Database Tables:**
- `qr_cards` - Employee QR assignments
- `qr_logs` - Scan history
- `attendance` - Attendance records (source_type='qr')
