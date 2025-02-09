<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Party Run Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-pink-500 to-blue-500 min-h-screen text-white">
    <!-- Tombol Fullscreen -->
    <button onclick="toggleFullscreen()" class="fixed top-4 right-4 bg-pink-600 text-white p-2 rounded-lg shadow-lg hover:bg-pink-700 transition-all">
        <i class="fas fa-expand"></i> Fullscreen
    </button>

    <div class="container mx-auto p-4 max-w-2xl">
        <!-- Logo dan Header -->
        <div class="text-center py-4">
            <img src="{{ asset('Images/logo.png') }}" alt="Party Run Logo" class="h-24 mx-auto mb-4 animate-float">
            <div class="flex justify-center gap-4">
                <a href="https://instagram.com/party.run.smr" target="_blank" class="text-white hover:text-pink-400 transition-all">
                    <i class="fab fa-instagram text-2xl"></i>
                </a>
            </div>
        </div>

        <!-- Input BIB -->
        <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6 mb-4 shadow-lg hover:shadow-xl transition-all">
            <div class="flex gap-3">
                <input type="text" id="bibInput" placeholder="✨ Masukkan Nomor BIB" pattern="[0-9]*" class="flex-1 bg-white/25 border-2 border-white/30 rounded-xl px-4 py-3 text-white placeholder-white/80 focus:outline-none focus:border-pink-500 focus:ring-2 focus:ring-pink-500 transition-all">
                <button onclick="checkBib()" class="bg-pink-600 text-white px-6 py-3 rounded-xl flex items-center gap-2 hover:bg-pink-700 transition-all">
                    <i class="fas fa-search"></i> Check BIB
                </button>
            </div>
        </div>

        <!-- Camera Container -->
        <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all">
            <div class="relative aspect-w-4 aspect-h-3 bg-black rounded-2xl overflow-hidden border-2 border-white/30">
                <div id="reader" class="w-full h-full"></div>
                <div class="absolute inset-0 flex items-center justify-center bg-black/30">
                    <div class="relative w-56 h-56">
                        <div class="absolute inset-4 border-2 border-white/70 rounded-2xl"></div>
                        <div class="absolute left-4 right-4 h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent animate-scan"></div>
                        <div class="absolute w-10 h-10 border-4 border-pink-500 border-r-0 border-b-0 top-0 left-0 rounded-tl-2xl"></div>
                        <div class="absolute w-10 h-10 border-4 border-pink-500 border-l-0 border-b-0 top-0 right-0 rounded-tr-2xl"></div>
                        <div class="absolute w-10 h-10 border-4 border-pink-500 border-r-0 border-t-0 bottom-0 left-0 rounded-bl-2xl"></div>
                        <div class="absolute w-10 h-10 border-4 border-pink-500 border-l-0 border-t-0 bottom-0 right-0 rounded-br-2xl"></div>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-4">
                <button onclick="switchCamera()" class="flex-1 bg-white/25 border-2 border-white/30 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-white/35 transition-all">
                    <i class="fas fa-camera-rotate"></i> Ganti Kamera
                </button>
                <button onclick="scanAgain()" class="flex-1 bg-pink-600 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-pink-700 transition-all">
                    <i class="fas fa-qrcode"></i> Scan Ulang
                </button>
            </div>
        </div>
    </div>

    <!-- Result Modal -->
    <div id="resultModal" class="fixed inset-0 bg-black/90 hidden items-center justify-center p-0 w-full h-full overflow-hidden z-50">
        <div class="bg-white rounded-none w-full h-full max-w-none overflow-hidden flex flex-col">
            <!-- Modal Header -->
            <div class="flex justify-between items-center p-4 border-b border-gray-200">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('Images/1.png') }}" alt="Logo Sponsor" class="h-10 w-auto transition-transform hover:scale-105 cursor-pointer">
                    <h3 class="text-xl font-bold text-pink-600">Hasil Scan</h3>
                </div>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl p-2">
                    &times;
                </button>
            </div>
    
            <!-- Modal Body -->
            <div class="p-4 flex-1 flex flex-col">
                <!-- BIB Card Image -->
                <div class="w-full flex-grow flex items-center justify-center mb-4">
                    <img id="modalBibCard" alt="BIB Card" class="max-w-full max-h-[80%] object-contain rounded-xl hidden">
                </div>
    
                <!-- Loading State -->
                <div id="modalLoading" class="w-full flex-grow flex flex-col items-center justify-center">
                    <div class="w-12 h-12 border-4 border-pink-500 border-t-transparent rounded-full animate-spin"></div>
                    <span class="mt-3 text-gray-600">Memproses...</span>
                </div>
    
                <!-- Participant Info -->
                <div class="bg-gray-50 rounded-xl p-4 mt-4">
                    <div class="flex justify-between py-3 border-b border-gray-200">
                        <span class="text-gray-600 font-medium">Nomor BIB</span>
                        <span id="modalBibNumber" class="text-gray-900 font-semibold">-</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600 font-medium">Status</span>
                        <span id="modalStatus" class="text-gray-900 font-semibold">-</span>
                    </div>
                </div>
            </div>
    
            <!-- Modal Actions -->
            <div class="flex gap-3 p-4 border-t border-gray-200">
                <button onclick="closeModal()" class="flex-1 bg-pink-600 text-white px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-pink-700 transition-all">
                    <i class="fas fa-times"></i> Tutup
                </button>
                <button onclick="scanAgain()" class="flex-1 bg-white border-2 border-pink-600 text-pink-600 px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-pink-50 transition-all">
                    <i class="fas fa-qrcode"></i> Scan Ulang
                </button>
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

        // Scanner Logic
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
            document.getElementById('resultModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('resultModal').classList.add('hidden');
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