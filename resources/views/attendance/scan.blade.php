@extends('layouts.app')
@section('content')
<h2>Scan QR Code for Attendance</h2>
<div class="card p-4" style="max-width:600px;">
    <form id="scan-form">
        @csrf
        <label for="qr_input" class="form-label">Scan QR code (scanner acts as keyboard)</label>
        <input id="qr_input" type="text" name="qr_code" autofocus placeholder="Scan QR code here" required class="form-control" autocomplete="off">
        <div id="scan-result" class="mt-3"></div>
    </form>
</div>

<script>
    (function(){
        const input = document.getElementById('qr_input');
        const result = document.getElementById('scan-result');
        let buffer = '';
        let lastTime = Date.now();

        // Submit scanner input via AJAX to the API endpoint
        async function submitCode(code){
            if(!code) return;
            try{
                const res = await fetch('/api/qr-scan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ qr_code: code })
                });
                const data = await res.json();
                if(res.ok){
                    result.innerHTML = `<div class="alert alert-success">${data.attendance?.message ?? 'Scan recorded'} (${data.attendance?.type ?? ''})</div>`;
                } else {
                    result.innerHTML = `<div class="alert alert-danger">${data.message ?? 'Scan failed'}</div>`;
                }
            } catch (e){
                result.innerHTML = `<div class="alert alert-danger">Network error</div>`;
            } finally{
                // clear input and focus for next scan
                input.value = '';
                input.focus();
            }
        }

        // If your scanner sends an Enter/Return after the code (common), listen for Enter
        input.addEventListener('keydown', function(e){
            if(e.key === 'Enter'){
                e.preventDefault();
                const code = input.value.trim();
                submitCode(code);
            }
        });

        // For scanners that paste the full value quickly without Enter, detect fast typing
        input.addEventListener('input', function(e){
            const now = Date.now();
            // If characters come faster than 50ms per char, assume scanner
            const delta = now - lastTime;
            lastTime = now;
            buffer = input.value;
            // if length > 6 and delta small, auto-submit after short timeout
            if(buffer.length >= 6){
                clearTimeout(input._submitTimeout);
                input._submitTimeout = setTimeout(() => {
                    submitCode(buffer.trim());
                }, 120);
            }
        });

        // Focus input on click anywhere to make kiosk-friendly
        document.addEventListener('click', ()=> input.focus());
    })();
</script>
@endsection
