@extends('layouts.employee')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Your Employee ID Card</h2>
        <div>
            <button id="print-card" class="btn btn-secondary">Print Card</button>
            <button id="download-card" class="btn btn-primary">Download as Image</button>
        </div>
    </div>

    @if($employee->qr_code)
        <!-- ID Card Container -->
        <div id="id-card" style="
            width: 350px;
            height: 560px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 20px;
            color: white;
            font-family: Arial, sans-serif;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            margin: 20px auto;
            position: relative;
            overflow: hidden;
        ">
            <!-- Header -->
            <div style="text-align:center; margin-bottom:15px;">
                <div style="font-size:24px; font-weight:bold;">Trackio</div>
                <div style="font-size:11px; opacity:0.9;">Employee Attendance System</div>
                <div style="font-size:11px; opacity:0.9;">EMPLOYEE ID CARD</div>
            </div>

            <!-- Photo Section (circular) -->
            <div style="text-align:center; margin-bottom:15px;">
                <div style="
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;
                    background: white;
                    margin: 0 auto;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    overflow: hidden;
                    border: 3px solid white;
                ">
                    @if($employee->photo)
                        <img src="{{ asset($employee->photo) }}" style="width:100%; height:100%; object-fit:cover;">
                    @else
                        <div style="font-size:40px; color:#667eea;">👤</div>
                    @endif
                </div>
            </div>

            <!-- Employee Info -->
            <div style="text-align:center; margin-bottom:15px;">
                <div style="font-size:16px; font-weight:bold;">{{ $employee->name }}</div>
                <div style="font-size:11px; opacity:0.9;">{{ $employee->employee_code }}</div>
            </div>

            <!-- Details -->
            <div style="font-size:10px; line-height:1.6; margin-bottom:15px; text-align:center;">
                <div><strong>Department:</strong> {{ $employee->department?->name ?? 'Not Assigned' }}</div>
                <div><strong>Designation:</strong> {{ $employee->designation?->designation_name ?? 'Not Assigned' }}</div>
                <div><strong>Joining:</strong> {{ $employee->joining_date ? date('d M Y', strtotime($employee->joining_date)) : 'Not Set' }}</div>
            </div>

            <!-- QR Code Section -->
            <div style="text-align:center; margin-bottom:10px;">
                <img id="card-qr" src="{{ asset($employee->qr_code_path) }}" alt="QR Code" style="width:80px; height:80px; display:block; margin:0 auto;">
            </div>

            <!-- Footer -->
            <div style="text-align:center; font-size:9px; opacity:0.8; border-top:1px solid rgba(255,255,255,0.3); padding-top:10px;">
                <div>{{ $employee->email }}</div>
                <div>{{ $employee->phone ?? 'N/A' }}</div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            Your QR code has not been generated yet. Please contact your administrator.
        </div>
    @endif
</div>

<script>
    document.getElementById('print-card').addEventListener('click', function(){
        const card = document.getElementById('id-card').cloneNode(true);
        const printWindow = window.open('', '', 'width=800,height=600');
        const css = `
            <style>
                body { margin:0; padding:20px; display:flex; justify-content:center; align-items:center; min-height:100vh; }
                #id-card { width: 500px; height: 800px; }
            </style>
        `;
        printWindow.document.write(css + card.outerHTML);
        printWindow.document.close();
        setTimeout(() => printWindow.print(), 250);
    });

    document.getElementById('download-card').addEventListener('click', async function(){
        this.disabled = true;
        this.textContent = 'Processing...';
        try {
            const card = document.getElementById('id-card');
            const canvas = document.createElement('canvas');
            const scale = 3;
            canvas.width = 1050;
            canvas.height = 1680;
            const ctx = canvas.getContext('2d');

            // Fill white background
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Use html2canvas if available for better rendering
            if(typeof html2canvas !== 'undefined'){
                const tempDiv = document.createElement('div');
                tempDiv.style.position = 'absolute';
                tempDiv.style.left = '-9999px';
                tempDiv.appendChild(card.cloneNode(true));
                document.body.appendChild(tempDiv);

                const result = await html2canvas(tempDiv.querySelector('#id-card'), {
                    scale: 2,
                    useCORS: true,
                    backgroundColor: '#ffffff',
                    logging: false
                });

                document.body.removeChild(tempDiv);
                const pngData = result.toDataURL('image/png');
                downloadPng(pngData, '{{ $employee->qr_code }}_IDCard.png');
            } else {
                // Fallback: simple SVG to PNG conversion
                alert('Note: Using simple conversion. For better quality, try again or refresh the page.');
                const svgData = `<svg width="1050" height="1680" xmlns="http://www.w3.org/2000/svg">
                    <rect width="1050" height="1680" fill="white"/>
                    <foreignObject width="1050" height="1680" x="0" y="0">
                        <div xmlns="http://www.w3.org/1999/xhtml">${card.innerHTML}</div>
                    </foreignObject>
                </svg>`;
                const img = new Image();
                img.onload = function(){
                    ctx.drawImage(img, 0, 0);
                    const pngData = canvas.toDataURL('image/png');
                    downloadPng(pngData, '{{ $employee->qr_code }}_IDCard.png');
                };
                img.src = 'data:image/svg+xml;base64,' + btoa(svgData);
            }
        } catch(e){
            console.error('Error:', e);
            alert('Error generating image: ' + e.message + '. Check browser console for details.');
        } finally {
            this.disabled = false;
            this.textContent = 'Download as Image';
        }
    });

    function downloadPng(dataUrl, filename){
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = filename;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    }
</script>

<!-- Include html2canvas for card image generation (optional) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" defer></script>
@endsection
