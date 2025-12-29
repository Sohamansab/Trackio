<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\PublicQrController;
use App\Models\Attendance;
use App\Models\QrLog;

$code = $argv[1] ?? 'EMP0001';
$request = Request::create('/qr/' . $code, 'GET');
$request->server->set('REMOTE_ADDR', '127.0.0.1');

$controller = new PublicQrController();

try {
    $response = $controller->show($request, $code);
    echo "Controller executed.\n";
} catch (\Throwable $e) {
    echo "Controller threw: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

// Print last QrLog and last attendance for this emp
$qrLogs = QrLog::where('emp_id', substr($code,3))->orderBy('qr_log_id','desc')->take(5)->get();
echo "QrLogs:\n";
foreach($qrLogs as $l) {
    echo $l->qr_log_id . ' | ' . $l->emp_id . ' | ' . $l->type . ' | ' . $l->timestamp . "\n";
}

$attendance = Attendance::where('emp_id', substr($code,3))->orderBy('attendance_id','desc')->first();
if ($attendance) {
    echo "Attendance: ";
    echo json_encode($attendance->toArray()) . "\n";
} else {
    echo "No attendance record found for emp (" . substr($code,3) . ").\n";
}
