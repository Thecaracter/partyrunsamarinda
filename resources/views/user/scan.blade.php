<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Party Run Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FF69B4, #00bfff);
            color: white;
        }

        .container {
            max-width: 640px;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Logo and Header */
        .logo {
            text-align: center;
            padding: 1rem 0;
        }

        .logo img {
            height: 100px;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .social-links a {
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .social-links a:hover {
            color: #FF1493;
        }

        /* Cards */
        .glass-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.2);
        }

        /* Input Group */
        .input-group {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        input {
            flex: 1;
            padding: 1rem 1.25rem;
            background: rgba(255, 255, 255, 0.25);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #FF1493;
            box-shadow: 0 0 15px rgba(255, 20, 147, 0.3);
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }

        /* Buttons */
        .btn-primary {
            background: #FF1493;
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #FF69B4;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.35);
            transform: translateY(-2px);
        }

        /* Camera Container */
        .camera-container {
            position: relative;
            width: 100%;
            aspect-ratio: 4/3;
            border-radius: 20px;
            overflow: hidden;
            background: black;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        #reader {
            width: 100%;
            height: 100%;
        }

        /* Hide QR Scanner Elements */
        #reader__header_message,
        #reader__status_span,
        #reader__dashboard_section_csr button {
            display: none !important;
        }

        .viewfinder-container {
            position: absolute;
            inset: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, 0.3);
            z-index: 20;
        }

        .viewfinder {
            position: relative;
            width: 220px;
            height: 220px;
            background: transparent;
        }

        .scan-area {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid rgba(255, 255, 255, 0.7);
            border-radius: 20px;
        }

        .corner {
            position: absolute;
            width: 35px;
            height: 35px;
            border: 4px solid #FF1493;
        }

        .corner-tl {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
            border-radius: 20px 0 0 0;
        }

        .corner-tr {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
            border-radius: 0 20px 0 0;
        }

        .corner-bl {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 20px;
        }

        .corner-br {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
            border-radius: 0 0 20px 0;
        }

        .scan-line {
            position: absolute;
            left: 15px;
            right: 15px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #FF1493, transparent);
            animation: scan 2s linear infinite;
        }

        @keyframes scan {
            0% { top: 15px; opacity: 1; }
            50% { opacity: 0.5; }
            100% { top: calc(100% - 17px); opacity: 1; }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
            overflow-y: auto;
        }

        .modal-content {
            position: relative;
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin: 1rem auto;
            max-width: 500px;
            width: 100%;
            animation: slideIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #FF1493;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            padding: 0.5rem;
        }

        .modal-body {
            padding: 1rem 0;
        }

        .modal-body img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .modal-loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            color: #6b7280;
        }

        .modal-loading i {
            margin-right: 0.5rem;
        }

        /* Participant Info */
        .participant-info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            color: #0f172a;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 640px) {
            .container { 
                padding: 0.75rem; 
            }
            
            .input-group { 
                flex-direction: column; 
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .viewfinder {
                width: 180px;
                height: 180px;
            }

            .modal {
                padding: 0;
            }
            
            .modal-content {
                margin: 0;
                min-height: 100vh;
                border-radius: 0;
                display: flex;
                flex-direction: column;
            }

            .modal-body {
                flex: 1;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                padding: 1rem;
            }
            
            .modal-header {
                padding: 1rem;
                margin-bottom: 0;
                position: sticky;
                top: 0;
                background: white;
                z-index: 10;
            }
            
            .modal-close {
                padding: 1rem;
                margin: -1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Tombol Fullscreen -->
    <button onclick="toggleFullscreen()" class="btn-fullscreen" style="position: fixed; top: 10px; right: 10px; background: #FF1493; color: white; border: none; padding: 0.5rem 1rem; border-radius: 12px; cursor: pointer;">
        <i class="fas fa-expand"></i> Fullscreen
    </button>

    <div class="container">
        <div class="logo">
            <img src="{{ asset('Images/logo.png') }}" alt="Party Run Logo">
            <div class="social-links">
                <a href="https://instagram.com/party.run.smr" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>

        <div class="glass-card">
            <div class="input-group">
                <input type="text" id="bibInput" placeholder="✨ Masukkan Nomor BIB" pattern="[0-9]*">
                <button onclick="checkBib()" class="btn-primary">
                    <i class="fas fa-search"></i>
                    Check BIB
                </button>
            </div>
        </div>

        <div class="glass-card">
            <div class="camera-container">
                <div class="loading-message">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Initializing camera...</p>
                </div>
                <div id="reader"></div>
                <div class="viewfinder-container">
                    <div class="viewfinder">
                        <div class="scan-area"></div>
                        <div class="scan-line"></div>
                        <div class="corner corner-tl"></div>
                        <div class="corner corner-tr"></div>
                        <div class="corner corner-bl"></div>
                        <div class="corner corner-br"></div>
                    </div>
                </div>
            </div>

            <div class="input-group" style="margin-top: 1rem; margin-bottom: 0;">
                <button onclick="switchCamera()" class="btn-secondary">
                    <i class="fas fa-camera-rotate"></i>
                    Ganti Kamera
                </button>
                <button onclick="scanAgain()" class="btn-primary">
                    <i class="fas fa-qrcode"></i>
                    Scan Ulang
                </button>
            </div>
        </div>
    </div>

    <!-- Result Modal -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <img 
                        src="{{ asset('Images/1.png') }}" 
                        alt="Logo Sponsor" 
                        style="
                            height: 50px; 
                            width: auto; /* Biarkan width menyesuaikan proporsi asli logo */
                            transition: transform 0.3s ease, opacity 0.3s ease;
                            cursor: pointer;
                        "
                        onmouseover="this.style.transform='scale(1.1)'; this.style.opacity='0.9';"
                        onmouseout="this.style.transform='scale(1)'; this.style.opacity='1';"
                    >
                </div>
                <button onclick="closeModal()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-loading" id="modalLoading">
                    <div class="loading-spinner">
                        <div class="spinner"></div>
                        <span>Memproses...</span>
                    </div>
                </div>
                <img id="modalBibCard" alt="BIB Card" style="width: 100%; height: auto; border-radius: 12px; margin-bottom: 1rem; display: none;">
                <div class="participant-info">
                    <div class="info-item">
                        <span class="info-label">Nomor BIB</span>
                        <span class="info-value" id="modalBibNumber">-</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="info-value" id="modalStatus">-</span>
                    </div>
                </div>
                <div class="modal-actions" style="display: flex; gap: 0.5rem; margin-top: 1.5rem;">
                    <button onclick="closeModal()" class="btn-close" style="background: #FF1493; color: white; border: none; padding: 0.75rem 1rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: background 0.3s ease; flex: 1;">
                        <i class="fas fa-times"></i>
                        Tutup
                    </button>
                    <button onclick="scanAgain()" class="btn-scan-again" style="background: rgba(255, 20, 147, 0.1); color: #FF1493; border: 2px solid #FF1493; padding: 0.75rem 1rem; border-radius: 12px; font-weight: 600; cursor: pointer; transition: background 0.3s ease; flex: 1;">
                        <i class="fas fa-qrcode"></i>
                        Scan Ulang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fullscreen Functionality
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable fullscreen: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }

        // Fullscreen Change Event
        document.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement) {
                console.log('Entered fullscreen mode');
            } else {
                console.log('Exited fullscreen mode');
            }
        });


        let html5QrcodeScanner;
        let currentCamera = 'environment';

        async function initializeScanner() {
            try {
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 4/3,
                    rememberLastUsedCamera: true,
                    showTorchButtonIfSupported: true
                };

                html5QrcodeScanner = new Html5Qrcode("reader");
                await html5QrcodeScanner.start(
                    { facingMode: currentCamera },
                    config,
                    onScanSuccess,
                    onScanError
                );

                document.querySelector('.loading-message').style.display = 'none';
            } catch (err) {
                console.error('Failed to start scanner:', err);
                document.querySelector('.loading-message').innerHTML = `
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Failed to start camera: ${err.message}</p>
                `;
            }
        }

        function onScanSuccess(decodedText) {
            try {
                processBibNumber(decodedText);
            } catch (error) {
                console.error('Error in scan success handler:', error);
                showError('An error occurred while processing the QR code');
            }
        }

        function onScanError(errorMessage) {
            console.warn(`QR scan error: ${errorMessage}`);
        }

        function checkBib() {
            const bibInput = document.getElementById('bibInput');
            const bib = bibInput.value.trim();
            
            if(!bib) {
                showError('Please enter a BIB number');
                return;
            }

            processBibNumber(bib);
        }

        function processBibNumber(bib) {
            let formattedNumber = bib;
            if (!bib.startsWith('2')) {
                formattedNumber = '2' + bib.padStart(4, '0');
            }

            const modalBibCard = document.getElementById('modalBibCard');
            const modalBibNumber = document.getElementById('modalBibNumber');
            const modalStatus = document.getElementById('modalStatus');
            const modalLoading = document.getElementById('modalLoading');
            
            modalLoading.style.display = 'flex';
            modalBibCard.style.display = 'none';
            
            modalBibCard.src = `{{ route('scan.getBibCard', '') }}/${formattedNumber}`;
            modalBibNumber.textContent = formattedNumber;
            modalStatus.textContent = 'Menunggu...';
            
            showModal();
            
            modalBibCard.onload = function() {
                modalLoading.style.display = 'none';
                modalBibCard.style.display = 'block';
                modalStatus.textContent = 'Valid';
                modalStatus.style.color = '#10B981';
            };
            
            modalBibCard.onerror = function() {
                closeModal();
                showError('BIB tidak ditemukan');
            };
        }

        async function switchCamera() {
            if (html5QrcodeScanner) {
                await html5QrcodeScanner.stop();
                currentCamera = currentCamera === 'environment' ? 'user' : 'environment';
                initializeScanner();
            }
        }

        function showError(message) {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#FF1493',
                background: 'white',
                customClass: {
                    popup: 'glass-card'
                }
            });
        }

        function showModal() {
            document.getElementById('resultModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('resultModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('DOMContentLoaded', initializeScanner);

        window.onclick = function(event) {
            const modal = document.getElementById('resultModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        window.addEventListener('beforeunload', () => {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop();
            }
        });

        document.getElementById('bibInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkBib();
            }
        });
    </script>
</body>
</html>