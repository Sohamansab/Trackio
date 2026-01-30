<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeProfile;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\QrCard;

class EmployeeQrController extends Controller
{
    public function generate($emp_id)
    {
        $employee = EmployeeProfile::findOrFail($emp_id);
        $qrValue = 'EMP' . str_pad($employee->emp_id, 4, '0', STR_PAD_LEFT);
        $employee->qr_code = $qrValue;
        $employee->save();

        // Generate QR code image and store it
        $image = \QrCode::format('svg')->size(200)->generate($qrValue);
        $path = 'qr-cards/' . $qrValue . '.svg';
        // store
        Storage::disk('public')->put($path, $image);
        $employee->qr_code_path = 'storage/qr-cards/' . $qrValue . '.svg';
        $employee->save();

        // Create or update qr_cards
        QrCard::updateOrCreate(
            ['emp_id' => $employee->emp_id],
            ['qr_code_path' => $employee->qr_code_path]
        );

        return redirect()->route('admin.employee.qr.show', $employee->emp_id)
            ->with('success', 'QR code generated!');
    }

    public function show($emp_id)
    {
        $employee = EmployeeProfile::findOrFail($emp_id);
        return view('admin.employee_qr', compact('employee'));
    }
}
