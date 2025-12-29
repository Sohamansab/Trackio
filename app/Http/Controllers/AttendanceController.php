<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        $response = Http::post(url('/api/qr-scan'), [
            'qr_code' => $request->qr_code
        ]);
        $result = $response->json();
        return back()->with('message', $result['message'] ?? 'Scan processed');
    }
}
