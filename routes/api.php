<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\QRCodeController;

// QR scanning endpoint
Route::post('/qr-scan', [QRCodeController::class, 'scan']);
