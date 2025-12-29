<?php
namespace App\Observers;

use App\Models\EmployeeProfile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\QrCard;

class EmployeeProfileObserver
{
    /**
     * Handle the EmployeeProfile "created" event.
     */
    public function created(EmployeeProfile $employee): void
    {
        // Generate QR code value and store SVG on the public disk
        $qrValue = 'EMP' . str_pad($employee->emp_id, 4, '0', STR_PAD_LEFT);
        $employee->qr_code = $qrValue;

        $publicUrl = url('/qr/' . $qrValue);
        $image = QrCode::format('svg')->size(200)->generate($publicUrl);

        Storage::disk('public')->put('qr-cards/' . $qrValue . '.svg', $image);
        $employee->qr_code_path = 'storage/qr-cards/' . $qrValue . '.svg';
        $employee->save();
        // Ensure a qr_cards row exists for this employee
        QrCard::updateOrCreate(
            ['emp_id' => $employee->emp_id],
            ['qr_code_path' => $employee->qr_code_path]
        );
    }
}
