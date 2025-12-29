<?php
namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EmployeeQrController extends Controller
{
    public function show()
    {
        $employee = Auth::user()->employeeProfile;
        return view('employee.qr', compact('employee'));
    }
}
