@extends('layouts.app')

@section('title', 'QR Scanner')

@push('styles')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <style>
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 640px;
            aspect-ratio: 4/3;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #fff;
            margin: 0 auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        #reader {
            width: 100%;
            height: 100%;
        }

        .viewfinder-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.3);
        }

        .viewfinder {
            position: relative;
            width: 200px;
            height: 200px;
            background: transparent;
        }

        .scan-area {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }

        .corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 4px solid #000;
        }

        .corner-tl {
            top: 0;
            left: 0;
            border-right: none;
            border-bottom: none;
            border-radius: 15px 0 0 0;
        }

        .corner-tr {
            top: 0;
            right: 0;
            border-left: none;
            border-bottom: none;
            border-radius: 0 15px 0 0;
        }

        .corner-bl {
            bottom: 0;
            left: 0;
            border-right: none;
            border-top: none;
            border-radius: 0 0 0 15px;
        }

        .corner-br {
            bottom: 0;
            right: 0;
            border-left: none;
            border-top: none;
            border-radius: 0 0 15px 0;
        }

        .preview-container {
            display: none;
            width: 100%;
            max-width: 640px;
            aspect-ratio: 4/3;
            margin: 0 auto;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .preview-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .controls {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .control-button {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container mx-auto px-4 md:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto py-8">
            <!-- Scanner Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-black px-6 py-4">
                    <h2 class="text-2xl font-bold text-white text-center">Party Run QR Scanner</h2>
                </div>
                <div class="p-6">
                    <div class="camera-container" id="cameraView">
                        <div id="reader"></div>
                        <div class="viewfinder-container">
                            <div class="viewfinder">
                                <div class="scan-area"></div>
                                <div class="corner corner-tl"></div>
                                <div class="corner corner-tr"></div>
                                <div class="corner corner-bl"></div>
                                <div class="corner corner-br"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Container -->
                    <div class="preview-container mt-4" id="previewView">
                        <img id="capturedImage" alt="Scanned QR">
                    </div>

                    <!-- Controls -->
                    <div class="controls mt-4">
                        <button onclick="switchCamera()" class="control-button bg-white text-black border border-gray-200 hover:bg-gray-50">
                            <i class="fas fa-camera-rotate"></i>
                            Switch Camera
                        </button>
                        <button onclick="scanAgain()" class="control-button bg-black text-white hover:bg-blue-800">
                            <i class="fas fa-qrcode"></i>
                            Scan Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let html5QrcodeScanner;
        let currentCamera = 'environment';

        function onScanSuccess(decodedText) {
            html5QrcodeScanner.pause();
            
            // Show the image
            const previewView = document.getElementById('previewView');
            const capturedImage = document.getElementById('capturedImage');
            capturedImage.src = `{{ route('scan.getBibCard', '') }}/${decodedText}`;
            previewView.style.display = 'block';
            
            // Hide the scanner view
            document.getElementById('cameraView').style.display = 'none';
        }

        function onScanError(errorMessage) {
            // Handle scan error if needed
            console.warn(`QR scan error: ${errorMessage}`);
        }

        function startScanner() {
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                experimentalFeatures: {
                    useBarCodeDetectorIfSupported: true
                }
            };

            html5QrcodeScanner = new Html5Qrcode("reader");
            html5QrcodeScanner.start(
                { facingMode: currentCamera },
                config,
                onScanSuccess,
                onScanError
            );
        }

        function switchCamera() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    currentCamera = currentCamera === 'environment' ? 'user' : 'environment';
                    startScanner();
                });
            }
        }

        function scanAgain() {
            document.getElementById('previewView').style.display = 'none';
            document.getElementById('cameraView').style.display = 'block';
            if (html5QrcodeScanner) {
                html5QrcodeScanner.resume();
            }
        }

        // Start scanner when page loads
        document.addEventListener('DOMContentLoaded', function() {
            startScanner();
        });

        // Cleanup when leaving page
        window.addEventListener('beforeunload', function() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop();
            }
        });
    </script>
@endpush