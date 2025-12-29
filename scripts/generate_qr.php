<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EmployeeProfile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

$empId = $argv[1] ?? 1;
$employee = EmployeeProfile::find($empId);
if (! $employee) {
    echo "Employee not found\n"; exit(1);
}
$qrValue = 'EMP' . str_pad($employee->emp_id, 4, '0', STR_PAD_LEFT);
$employee->qr_code = $qrValue;
// generate svg
$image = QrCode::format('svg')->size(200)->generate($qrValue);
$path = 'qr-cards/' . $qrValue . '.svg';
Storage::disk('public')->put($path, $image);
$employee->qr_code_path = 'storage/qr-cards/' . $qrValue . '.svg';
$employee->save();

echo "Generated QR for emp_id={$employee->emp_id} at {$employee->qr_code_path}\n";
