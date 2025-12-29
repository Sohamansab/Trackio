<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EmployeeProfile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\QrCard;

$employees = EmployeeProfile::all();

foreach ($employees as $e) {
    try {
        $qr = 'EMP' . str_pad($e->emp_id, 4, '0', STR_PAD_LEFT);
        $e->qr_code = $qr;
        $publicUrl = url('/qr/' . $qr);
        $image = QrCode::format('svg')->size(200)->generate($publicUrl);
        Storage::disk('public')->put('qr-cards/' . $qr . '.svg', $image);
        $e->qr_code_path = 'storage/qr-cards/' . $qr . '.svg';
        $e->save();
        
            // ensure qr_cards entry exists
            QrCard::updateOrCreate(
                ['emp_id' => $e->emp_id],
                ['qr_code_path' => $e->qr_code_path]
            );
        echo "Regenerated: {$qr}\n";
    } catch (\Throwable $ex) {
        echo "Failed for emp_id {$e->emp_id}: " . $ex->getMessage() . "\n";
    }
}

echo "Done\n";
