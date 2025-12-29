@extends('layouts.admin')

@section('title', 'Scan Attendance')

@section('content')
<div>
    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-qrcode text-primary me-2"></i>Scan Attendance</h1>
        <p class="text-muted">Scan QR codes to mark employee attendance</p>
    </div>

    <div class="row">
        <!-- QR Scanner Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-camera me-2"></i>QR Code Scanner
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div id="qr-reader" class="mb-3" style="width: 100%; max-width: 500px; margin: 0 auto;"></div>
                        <button id="start-scan" class="btn btn-primary mb-3">
                            <i class="fas fa-play me-2"></i>Start Scanning
                        </button>
                        <button id="stop-scan" class="btn btn-danger mb-3" style="display: none;">
                            <i class="fas fa-stop me-2"></i>Stop Scanning
                        </button>
                    </div>

                    <!-- Manual QR Code Input -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">Or enter QR code manually:</h6>
                        <div class="input-group">
                            <input type="text" id="manual-qr" class="form-control" placeholder="Enter QR code...">
                            <button class="btn btn-outline-primary" id="manual-submit">
                                <i class="fas fa-check me-2"></i>Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Scans Section -->
        <div class="col-lg-4">
            <div class="card border-0 shadow">
                <div class="card-header border-0 bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Recent Scans
                    </h5>
                </div>
                <div class="card-body">
                    <div id="recent-scans" class="list-group list-group-flush">
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p>No recent scans</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scan Result Modal -->
    <div class="modal fade" id="scanResultModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scanResultTitle">Scan Result</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="scanResultBody">
                    <!-- Result content will be inserted here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page-header {
        margin-bottom: 2rem;
    }
    #qr-reader {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 20px;
        background: #f8f9fa;
    }
    #qr-reader video {
        width: 100% !important;
        border-radius: 5px;
    }
    .list-group-item {
        border: none;
        padding: 0.75rem 0;
    }
    .list-group-item:not(:last-child) {
        border-bottom: 1px solid #f1f3f4;
    }
</style>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let html5QrCode = null;
    const qrReader = document.getElementById('qr-reader');
    const startScanBtn = document.getElementById('start-scan');
    const stopScanBtn = document.getElementById('stop-scan');
    const manualQrInput = document.getElementById('manual-qr');
    const manualSubmitBtn = document.getElementById('manual-submit');
    const recentScans = document.getElementById('recent-scans');

    // Initialize QR scanner
    function initQrScanner() {
        html5QrCode = new Html5Qrcode("qr-reader");
    }

    // Start scanning
    startScanBtn.addEventListener('click', function() {
        if (!html5QrCode) {
            initQrScanner();
        }

        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            onScanSuccess,
            onScanFailure
        ).then(() => {
            startScanBtn.style.display = 'none';
            stopScanBtn.style.display = 'inline-block';
            qrReader.style.borderColor = '#198754';
            qrReader.style.background = '#f8fff9';
        }).catch((err) => {
            console.error('Error starting scanner:', err);
            showResultModal('Error', 'Failed to start camera. Please check permissions.', 'danger');
        });
    });

    // Stop scanning
    stopScanBtn.addEventListener('click', function() {
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                startScanBtn.style.display = 'inline-block';
                stopScanBtn.style.display = 'none';
                qrReader.style.borderColor = '#dee2e6';
                qrReader.style.background = '#f8f9fa';
            });
        }
    });

    // Manual submit
    manualSubmitBtn.addEventListener('click', function() {
        const qrCode = manualQrInput.value.trim();
        if (qrCode) {
            processQrCode(qrCode);
            manualQrInput.value = '';
        }
    });

    // Enter key for manual input
    manualQrInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            manualSubmitBtn.click();
        }
    });

    // QR scan success callback
    function onScanSuccess(decodedText, decodedResult) {
        processQrCode(decodedText);
    }

    // QR scan failure callback
    function onScanFailure(error) {
        // Ignore scan failures, they're normal
    }

    // Process QR code
    function processQrCode(qrCode) {
        fetch('{{ route("admin.scan-attendance.scan") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_code: qrCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showResultModal('Success', data.message, 'success');
                addToRecentScans(data.data);
            } else {
                showResultModal('Error', data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showResultModal('Error', 'An error occurred while processing the QR code.', 'danger');
        });
    }

    // Show result modal
    function showResultModal(title, message, type) {
        const modal = new bootstrap.Modal(document.getElementById('scanResultModal'));
        document.getElementById('scanResultTitle').textContent = title;
        document.getElementById('scanResultBody').innerHTML = `
            <div class="alert alert-${type} mb-0">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
            </div>
        `;
        modal.show();
    }

    // Add to recent scans
    function addToRecentScans(data) {
        const scanItem = document.createElement('div');
        scanItem.className = 'list-group-item';
        scanItem.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong>${data.employee_name || 'Unknown'}</strong>
                    <br>
                    <small class="text-muted">${data.timestamp || new Date().toLocaleTimeString()}</small>
                </div>
                <span class="badge bg-${data.status === 'check_in' ? 'success' : 'warning'}">
                    ${data.status === 'check_in' ? 'Check In' : 'Check Out'}
                </span>
            </div>
        `;

        // Remove empty state if present
        const emptyState = recentScans.querySelector('.text-center');
        if (emptyState) {
            emptyState.remove();
        }

        // Add new item at top
        recentScans.insertBefore(scanItem, recentScans.firstChild);

        // Keep only last 10 items
        while (recentScans.children.length > 10) {
            recentScans.removeChild(recentScans.lastChild);
        }
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (html5QrCode) {
            html5QrCode.stop();
        }
    });
});
</script>
@endsection
