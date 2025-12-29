<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Employee QR — {{ $employee->name ?? $employee->employee_code }}</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f6f8fa;padding:20px}
        .card{max-width:480px;margin:40px auto;background:#fff;border-radius:8px;padding:20px;box-shadow:0 6px 18px rgba(0,0,0,.08)}
        .title{font-size:18px;font-weight:600;margin-bottom:8px}
        .muted{color:#666}
        .row{display:flex;justify-content:space-between;padding:10px 0;border-top:1px solid #eee}
        .val{font-weight:600}
        .ok{color:green}
    </style>
</head>
<body>
    <div class="card">
        <div class="title">{{ $employee->name ?? $employee->employee_code }}</div>
        <div class="muted">Employee Code: {{ $employee->employee_code ?? $employee->qr_code }}</div>

        <div style="margin-top:18px">
            <div class="row">
                <div>Check-in</div>
                <div class="val">{{ $attendance && $attendance->check_in ? $attendance->check_in : '—' }}</div>
            </div>
            <div class="row">
                <div>Check-out</div>
                <div class="val">{{ $attendance && $attendance->check_out ? $attendance->check_out : '—' }}</div>
            </div>
            <div class="row">
                <div>Status</div>
                <div class="val">{{ $attendance->status ?? '—' }}</div>
            </div>
        </div>

        @if($message)
            <div style="margin-top:16px;padding:10px;background:#eef9ee;border:1px solid #d4f2d4;color:#075c07;border-radius:4px">{{ $message }}</div>
        @endif

        <div style="margin-top:14px;color:#666;font-size:13px">Scanned at: {{ now()->format('d M Y H:i:s') }}</div>
    </div>
</body>
</html>
