@extends('layouts.app')

@section('title', 'Scanner Check-in')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <style>
        .camera-container {
            position: relative;
            width: 100%;
            max-width: 640px;
            aspect-ratio: 4/3;
            border-radius: 0.5rem;
            overflow: hidden;
            background: #000;
            margin: 0 auto;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding-bottom: env(safe-area-inset-bottom, 0px);
        }

        @media (min-width: 640px) {
            .camera-container {
                border-radius: 1rem;
                padding-bottom: 0;
            }
        }

        #preview {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #canvas {
            display: none;
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
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(2px);
        }

        .viewfinder {
            position: relative;
            width: 200px;
            height: 200px;
            background: transparent;
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @media (min-width: 640px) {
            .viewfinder {
                width: 280px;
                height: 280px;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .8;
            }
        }

        .scan-area {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 15px;
        }

        .corner {
            position: absolute;
            width: 30px;
            height: 30px;
            border: 4px solid #9333ea;
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

        .helper-text {
            position: absolute;
            top: -40px;
            left: 10px;
            right: 10px;
            text-align: center;
            color: white;
            font-size: 12px;
            font-weight: 500;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            background: rgba(0, 0, 0, 0.4);
            padding: 6px;
            border-radius: 6px;
            backdrop-filter: blur(4px);
        }

        @media (min-width: 640px) {
            .helper-text {
                top: -50px;
                left: 0;
                right: 0;
                font-size: 14px;
                padding: 8px;
                border-radius: 8px;
            }
        }

        .scan-line {
            position: absolute;
            left: 15px;
            right: 15px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #9333ea, transparent);
            animation: scan 2s linear infinite;
            box-shadow: 0 0 8px rgba(147, 51, 234, 0.6);
        }

        @keyframes scan {
            0% {
                top: 15px;
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                top: calc(100% - 17px);
                opacity: 1;
            }
        }

        .camera-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.5rem;
            z-index: 10;
            padding: 1rem;
            padding-bottom: 2rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 50%, transparent);
        }

        .preview-container {
            position: relative;
            width: 100%;
            max-width: 640px;
            aspect-ratio: 4/3;
            border-radius: 0.5rem;
            overflow: hidden;
            display: none;
            background-color: #f3f4f6;
            margin: 0 auto;
        }

        @media (min-width: 640px) {
            .preview-container {
                border-radius: 1rem;
            }
        }

        .preview-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .preview-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 0.5rem;
            z-index: 10;
            padding: 1rem;
            padding-bottom: 2rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 50%, transparent);
        }

        .control-button {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #d1d5db;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(4px);
            margin: 0 auto;
            max-width: calc(100% - 2rem);
        }

        .control-button:hover {
            background-color: #f3f4f6;
            transform: translateY(-1px);
        }

        .control-button.primary {
            background-color: #9333ea;
            color: white;
            border: none;
        }

        .control-button.primary:hover {
            background-color: #7e22ce;
        }

        @media (min-width: 640px) {

            .camera-controls,
            .preview-controls {
                flex-direction: row;
                bottom: 0;
                gap: 1rem;
                padding: 1rem;
                background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
                justify-content: center;
                align-items: center;
            }

            .control-button {
                width: auto;
                padding: 0.75rem 1.5rem;
                max-width: none;
                display: inline-flex;
                align-items: center;
            }
        }

        /* Tabs Styling */
        .tab-btn {
            border-bottom-width: 2px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            color: #6B7280;
            border-color: transparent;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: #111827;
        }

        .tab-btn.active {
            color: #9333EA;
            border-color: #9333EA;
        }

        /* Table Styling */
        .table-container {
            margin-top: 2rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .participant-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .participant-row:hover {
            background-color: #F9FAFB;
        }

        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .status-badge.checked-in {
            background-color: #DEF7EC;
            color: #03543F;
        }

        .status-badge.not-checked-in {
            background-color: #FEF3C7;
            color: #92400E;
        }

        @media (max-width: 640px) {
            .table-container {
                margin-top: 1rem;
            }

            .status-badge {
                padding: 0.2rem 0.5rem;
                font-size: 0.7rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4 sm:mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0 flex-1">
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold leading-7 text-gray-900 sm:tracking-tight">
                            Scanner Check-in
                        </h2>
                        <p class="mt-1 text-sm text-gray-500">
                            Scan QR code peserta untuk proses check-in
                        </p>
                    </div>
                </div>
            </div>
            <!-- Scanner Section -->
            <div class="bg-white rounded-lg sm:rounded-xl shadow-sm overflow-hidden mb-4 sm:mb-8">
                <div class="p-4 sm:p-6">
                    <div class="max-w-xl mx-auto">
                        <div class="space-y-4">
                            <!-- Camera View -->
                            <div class="camera-container relative" id="cameraView">
                                <video id="preview" class="w-full h-full object-cover" playsinline autoplay></video>
                                <canvas id="canvas" class="hidden"></canvas>
                                <div class="viewfinder-container">
                                    <div class="viewfinder">
                                        <div class="helper-text text-sm sm:text-base">Arahkan QR Code ke dalam kotak</div>
                                        <div class="scan-line"></div>
                                        <div class="scan-area"></div>
                                        <div class="corner corner-tl"></div>
                                        <div class="corner corner-tr"></div>
                                        <div class="corner corner-bl"></div>
                                        <div class="corner corner-br"></div>
                                    </div>
                                </div>

                                <!-- Desktop Camera Controls -->
                                <div
                                    class="hidden sm:flex absolute bottom-0 inset-x-0 items-center justify-center p-6 bg-gradient-to-t from-black/70 to-transparent">
                                    <div class="flex gap-4">
                                        <button onclick="switchCamera()"
                                            class="py-2.5 px-6 bg-white/90 backdrop-blur text-gray-900 rounded-lg shadow-sm hover:bg-white transition-colors text-sm font-medium">
                                            <i class="fas fa-camera-rotate mr-2"></i> Ganti Kamera
                                        </button>
                                        <button onclick="capturePhoto()"
                                            class="py-2.5 px-6 bg-purple-600 text-white rounded-lg shadow-sm hover:bg-purple-700 transition-colors text-sm font-medium">
                                            <i class="fas fa-camera mr-2"></i> Ambil Foto
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Camera Controls -->
                            <div class="flex flex-col sm:hidden gap-2 px-2">
                                <button onclick="switchCamera()"
                                    class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-400 to-blue-600 text-white rounded-lg shadow-sm hover:from-blue-500 hover:to-blue-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-camera-rotate mr-2"></i> Ganti Kamera
                                </button>
                                <button onclick="capturePhoto()"
                                    class="w-full py-2.5 px-4 bg-gradient-to-r from-emerald-400 to-emerald-600 text-white rounded-lg shadow-sm hover:from-emerald-500 hover:to-emerald-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-camera mr-2"></i> Ambil Foto
                                </button>
                                <button onclick="retakePhoto()"
                                    class="w-full py-2.5 px-4 bg-gradient-to-r from-rose-400 to-rose-600 text-white rounded-lg shadow-sm hover:from-rose-500 hover:to-rose-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-arrow-rotate-left mr-2"></i> Ambil Ulang
                                </button>
                                <button onclick="scanQR()"
                                    class="w-full py-2.5 px-4 bg-gradient-to-r from-amber-400 to-amber-600 text-white rounded-lg shadow-sm hover:from-amber-500 hover:to-amber-700 transition-colors text-sm font-medium">
                                    <i class="fas fa-qrcode mr-2"></i> Scan QR
                                </button>
                            </div>

                            <!-- Preview Section -->
                            <div class="preview-container relative" id="previewView">
                                <img id="capturedImage" src="" alt="Captured QR"
                                    class="w-full h-full object-contain">

                                <!-- Desktop Preview Controls -->
                                <div
                                    class="hidden sm:flex absolute bottom-0 inset-x-0 items-center justify-center p-6 bg-gradient-to-t from-black/70 to-transparent">
                                    <div class="flex gap-4">
                                        <button onclick="retakePhoto()"
                                            class="py-2.5 px-6 bg-white/90 backdrop-blur text-gray-900 rounded-lg shadow-sm hover:bg-white transition-colors text-sm font-medium">
                                            <i class="fas fa-arrow-rotate-left mr-2"></i> Ambil Ulang
                                        </button>
                                        <button onclick="scanQR()"
                                            class="py-2.5 px-6 bg-purple-600 text-white rounded-lg shadow-sm hover:bg-purple-700 transition-colors text-sm font-medium">
                                            <i class="fas fa-qrcode mr-2"></i> Scan QR
                                        </button>
                                    </div>
                                </div>

                                <!-- Mobile Preview Controls -->
                                <div class="flex sm:hidden mt-4 flex-col gap-2 px-2">
                                    <button onclick="retakePhoto()"
                                        class="w-full py-2.5 px-4 bg-white text-gray-900 rounded-lg border border-gray-300 shadow-sm hover:bg-gray-50 transition-colors text-sm font-medium">
                                        <i class="fas fa-arrow-rotate-left mr-2"></i> Ambil Ulang
                                    </button>
                                    <button onclick="scanQR()"
                                        class="w-full py-2.5 px-4 bg-purple-600 text-white rounded-lg shadow-sm hover:bg-purple-700 transition-colors text-sm font-medium">
                                        <i class="fas fa-qrcode mr-2"></i> Scan QR
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Participant Tables Section -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 sm:px-6 lg:px-8 py-6">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="-mb-px flex space-x-8">
                            <button onclick="switchTab('checkedIn')" class="tab-btn active" id="checkedInTab">
                                Sudah Check-in
                                <span
                                    class="bg-purple-100 text-purple-800 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium"
                                    id="checkedInCount">
                                    0
                                </span>
                            </button>
                            <button onclick="switchTab('notCheckedIn')" class="tab-btn" id="notCheckedInTab">
                                Belum Check-in
                                <span class="bg-gray-100 text-gray-800 ml-2 py-0.5 px-2.5 rounded-full text-xs font-medium"
                                    id="notCheckedInCount">
                                    0
                                </span>
                            </button>
                        </nav>
                    </div>

                    <!-- Tables -->
                    <div class="mt-6">
                        <!-- Checked In Table -->
                        <div id="checkedInTable" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            BIB
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu Check-in
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="checkedInTableBody">
                                    <!-- Data will be inserted here by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Not Checked In Table -->
                        <div id="notCheckedInTable" class="overflow-x-auto hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            BIB
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Kategori
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200" id="notCheckedInTableBody">
                                    <!-- Data will be inserted here by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/YOUR_KIT_CODE.js"></script>
    <script>
        let video = null;
        let canvasElement = null;
        let canvas = null;
        let currentStream = null;
        let currentCamera = 'environment';
        let capturedImage = null;
        let extractedBibNumber = null;
        let currentTab = 'checkedIn';

        // Inisialisasi data awal dari controller
        let initialCheckedIn = @json($checkedInPeserta);
        let initialNotCheckedIn = @json($notCheckedInPeserta);

        function initializeElements() {
            video = document.getElementById('preview');
            canvasElement = document.getElementById('canvas');
            if (canvasElement) {
                canvas = canvasElement.getContext('2d', {
                    willReadFrequently: true
                });
            }
            updateParticipantTables(initialCheckedIn, initialNotCheckedIn);
            updateCounters(initialCheckedIn.length, initialNotCheckedIn.length);
            loadParticipantData();
        }

        async function loadParticipantData() {
            try {
                const response = await fetch('/admin/peserta/data');
                const data = await response.json();

                if (data.success) {
                    updateParticipantTables(data.checkedIn, data.notCheckedIn);
                    updateCounters(data.checkedIn.length, data.notCheckedIn.length);
                }
            } catch (error) {
                console.error('Error loading participant data:', error);
            }
        }

        function formatDateTime(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }

        function updateParticipantTables(checkedInData, notCheckedInData) {
            // Urutkan data berdasarkan kode_bib secara descending
            const sortedCheckedIn = [...checkedInData].sort((a, b) =>
                parseInt(b.kode_bib) - parseInt(a.kode_bib)
            );

            const sortedNotCheckedIn = [...notCheckedInData].sort((a, b) =>
                parseInt(b.kode_bib) - parseInt(a.kode_bib)
            );

            const checkedInBody = document.getElementById('checkedInTableBody');
            const notCheckedInBody = document.getElementById('notCheckedInTableBody');

            // Update checked in table
            checkedInBody.innerHTML = sortedCheckedIn.map(participant => `
        <tr class="participant-row hover:bg-gray-50" onclick='showParticipantDetails(${JSON.stringify({
            ...participant,
            check_in_time: formatDateTime(participant.check_in_time)
        })})'>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">${participant.kode_bib}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${participant.nama_lengkap}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${participant.kategori}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-500">${formatDateTime(participant.check_in_time)}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="status-badge checked-in">Checked In</span>
            </td>
        </tr>
    `).join('');

            // Update not checked in table
            notCheckedInBody.innerHTML = sortedNotCheckedIn.map(participant => `
        <tr class="participant-row hover:bg-gray-50" onclick='showParticipantDetails(${JSON.stringify(participant)})'>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">${participant.kode_bib}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${participant.nama_lengkap}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">${participant.kategori}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="status-badge not-checked-in">Pending</span>
            </td>
        </tr>
    `).join('');
        }

        function updateCounters(checkedInCount, notCheckedInCount) {
            document.getElementById('checkedInCount').textContent = checkedInCount;
            document.getElementById('notCheckedInCount').textContent = notCheckedInCount;
        }

        function switchTab(tab) {
            currentTab = tab;
            const checkedInTab = document.getElementById('checkedInTab');
            const notCheckedInTab = document.getElementById('notCheckedInTab');
            const checkedInTable = document.getElementById('checkedInTable');
            const notCheckedInTable = document.getElementById('notCheckedInTable');

            if (tab === 'checkedIn') {
                checkedInTab.classList.add('active');
                notCheckedInTab.classList.remove('active');
                checkedInTable.classList.remove('hidden');
                notCheckedInTable.classList.add('hidden');
            } else {
                checkedInTab.classList.remove('active');
                notCheckedInTab.classList.add('active');
                checkedInTable.classList.add('hidden');
                notCheckedInTable.classList.remove('hidden');
            }
        }

        async function startCamera() {
            try {
                // Cek apakah browser mendukung getUserMedia dengan cara yang lebih spesifik
                if (!navigator?.mediaDevices?.getUserMedia && !navigator?.getUserMedia && !navigator
                    ?.webkitGetUserMedia && !navigator?.mozGetUserMedia) {
                    throw new Error('Browser anda tidak mendukung akses kamera');
                }

                // Gunakan constraints yang lebih sederhana untuk mobile
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator
                    .userAgent);

                const constraints = {
                    video: isMobile ? {
                        facingMode: currentCamera,
                        width: {
                            ideal: 1280
                        },
                        height: {
                            ideal: 720
                        }
                    } : {
                        facingMode: currentCamera,
                        width: {
                            min: 640,
                            ideal: 1280,
                            max: 1920
                        },
                        height: {
                            min: 480,
                            ideal: 720,
                            max: 1080
                        }
                    }
                };

                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                }

                let stream;

                // Gunakan legacy API jika getUserMedia tidak tersedia
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    stream = await navigator.mediaDevices.getUserMedia(constraints);
                } else {
                    const getUserMedia = navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mozGetUserMedia;

                    if (!getUserMedia) {
                        throw new Error('Browser anda tidak mendukung akses kamera');
                    }

                    stream = await new Promise((resolve, reject) => {
                        getUserMedia.call(navigator, constraints, resolve, reject);
                    });
                }

                currentStream = stream;
                if (video) {
                    video.srcObject = stream;
                    try {
                        await video.play();
                    } catch (playError) {
                        console.error('Error playing video:', playError);
                        // Tetap lanjutkan karena beberapa browser mungkin tidak memerlukan play()
                    }
                }

                document.getElementById('cameraView').style.display = 'block';
                document.getElementById('previewView').style.display = 'none';

            } catch (err) {
                console.error('Camera error:', err);

                // Handle specific permission errors
                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    Swal.fire({
                        title: 'Akses Kamera Ditolak',
                        html: `
                    <p class="mb-4">Mohon izinkan akses kamera untuk menggunakan fitur scan.</p>
                    <div class="text-left text-sm">
                        <p class="mb-2">Cara mengizinkan akses kamera:</p>
                        <ol class="list-decimal pl-4">
                            <li>Klik icon 🔒/🔐 di address bar browser</li>
                            <li>Cari pengaturan "Kamera"</li>
                            <li>Pilih "Izinkan"</li>
                            <li>Refresh halaman ini</li>
                        </ol>
                    </div>
                `,
                        icon: 'warning',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#9333ea'
                    });
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    Swal.fire({
                        title: 'Kamera Tidak Ditemukan',
                        text: 'Pastikan perangkat anda memiliki kamera yang berfungsi.',
                        icon: 'error',
                        confirmButtonColor: '#9333ea'
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal Mengakses Kamera',
                        html: `
                    <p class="mb-4">Terjadi kesalahan saat mengakses kamera.</p>
                    <div class="text-left text-sm">
                        <p class="mb-2">Silakan coba:</p>
                        <ol class="list-decimal pl-4">
                            <li>Pastikan anda menggunakan Chrome/Safari terbaru</li>
                            <li>Pastikan website dibuka via HTTPS</li>
                            <li>Coba refresh halaman</li>
                            <li>Restart browser anda</li>
                        </ol>
                    </div>
                `,
                        icon: 'error',
                        confirmButtonColor: '#9333ea'
                    });
                }
            }
        }
        async function checkCameraPermission() {
            try {
                const result = await navigator.permissions.query({
                    name: 'camera'
                });
                if (result.state === 'denied') {
                    Swal.fire({
                        title: 'Akses Kamera Ditolak',
                        html: `
                    <p class="mb-4">Mohon izinkan akses kamera untuk menggunakan fitur scan.</p>
                    <div class="text-left text-sm">
                        <p class="mb-2">Cara mengizinkan akses kamera:</p>
                        <ol class="list-decimal pl-4">
                            <li>Klik icon 🔒/🔐 di address bar browser</li>
                            <li>Cari pengaturan "Kamera"</li>
                            <li>Pilih "Izinkan"</li>
                            <li>Refresh halaman ini</li>
                        </ol>
                    </div>
                `,
                        icon: 'warning',
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#9333ea'
                    });
                    return false;
                }
                return true;
            } catch (error) {
                console.warn('Permissions API not supported');
                return true; // Proceed anyway if API not supported
            }
        }
        async function switchCamera() {
            currentCamera = currentCamera === 'environment' ? 'user' : 'environment';
            await startCamera();
        }

        function capturePhoto() {
            if (!video || !canvasElement || !canvas) return;

            canvasElement.width = video.videoWidth;
            canvasElement.height = video.videoHeight;
            canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height);
            capturedImage = canvasElement.toDataURL('image/jpeg');

            const capturedImageEl = document.getElementById('capturedImage');
            if (capturedImageEl) {
                capturedImageEl.src = capturedImage;
            }

            document.getElementById('cameraView').style.display = 'none';
            document.getElementById('previewView').style.display = 'block';

        }

        function retakePhoto() {
            capturedImage = null;
            document.getElementById('cameraView').style.display = 'block';
            document.getElementById('previewView').style.display = 'none';
        }

        async function scanQR() {
            if (!canvasElement || !canvas) return;

            const image = new Image();
            image.src = capturedImage;

            image.onload = function() {
                canvasElement.width = image.width;
                canvasElement.height = image.height;
                canvas.drawImage(image, 0, 0);

                const imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height);
                const code = jsQR(imageData.data, imageData.width, imageData.height, {
                    inversionAttempts: "dontInvert",
                });

                if (code) {
                    extractedBibNumber = extractBibNumber(code.data);
                    fetchPesertaData(extractedBibNumber);
                } else {
                    Swal.fire({
                        title: 'QR Code Tidak Ditemukan',
                        text: 'Silakan coba ambil foto ulang dengan QR code yang jelas.',
                        icon: 'error'
                    });
                }
            };
        }

        function extractBibNumber(text) {
            console.log('QR Data:', text);
            try {
                const url = new URL(text);
                const bibNumber = url.searchParams.get('kode_bib');
                if (bibNumber) {
                    return bibNumber.padStart(3, '0');
                }
            } catch (e) {
                const matches = text.match(/\d+/);
                if (matches) {
                    return matches[0].padStart(3, '0');
                }
            }
            return text;
        }

        async function fetchPesertaData(bibNumber) {
            try {
                const response = await fetch(`/admin/peserta/${bibNumber}`);
                const data = await response.json();

                if (response.ok) {
                    // Reset tampilan kamera
                    document.getElementById('cameraView').style.display = 'block';
                    document.getElementById('previewView').style.display = 'none';

                    // Tampilkan popup dengan format yang sama
                    Swal.fire({
                        title: 'Data Peserta',
                        html: `
                    <div class="text-left p-4 space-y-4 overflow-y-auto max-h-[70vh]">
                        <!-- Data Utama -->
                        <div class="grid grid-cols-2 gap-4 pb-3 border-b">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor BIB</label>
                                <p class="mt-1 text-sm text-gray-900">${data.kode_bib}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1">
                                    <span class="status-badge ${data.already_checked_in ? 'checked-in' : 'not-checked-in'}">
                                        ${data.already_checked_in ? 'Checked In' : 'Pending'}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Informasi Pribadi -->
                        <div class="space-y-3 pb-3 border-b">
                            <h4 class="font-semibold text-gray-900">Informasi Pribadi</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.nama_lengkap}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama BIB</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.nama_bib || '-'}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.email}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. WhatsApp</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.no_wa}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Usia</label>
                                <p class="mt-1 text-sm text-gray-900">${data.usia} tahun</p>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="space-y-3 pb-3 border-b">
                            <h4 class="font-semibold text-gray-900">Alamat</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.provinsi}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kota</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.kota}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.kecamatan}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kelurahan</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.kelurahan}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <p class="mt-1 text-sm text-gray-900">${data.alamat}</p>
                            </div>
                        </div>

                        <!-- Informasi Event -->
                        <div class="space-y-3 pb-3 border-b">
                            <h4 class="font-semibold text-gray-900">Informasi Event</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.kategori}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ukuran Baju</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.size ? data.size.name : '-'}</p>
                                </div>
                            </div>
                            ${data.check_in_time ? `
                                                                                                                                                        <div>
                                                                                                                                                            <label class="block text-sm font-medium text-gray-700">Waktu Check-in</label>
                                                                                                                                                            <p class="mt-1 text-sm text-gray-900">${formatDateTime(data.check_in_time)}</p>
                                                                                                                                                        </div>
                                                                                                                                                    ` : ''}
                        </div>

                        <!-- Informasi Medis -->
                        <div class="space-y-3 pb-3 border-b">
                            <h4 class="font-semibold text-gray-900">Informasi Medis</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.golongan_darah || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ada Alergi</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.ada_alergi ? 'Ya' : 'Tidak'}</p>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Riwayat Penyakit</label>
                                <p class="mt-1 text-sm text-gray-900">${data.riwayat_penyakit || '-'}</p>
                            </div>
                        </div>

                        <!-- Kontak Darurat -->
                        <div class="space-y-3 pb-3 border-b">
                            <h4 class="font-semibold text-gray-900">Kontak Darurat</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.emergency_nama || '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nomor</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.emergency_nomor || '-'}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pembayaran -->
                        <div class="space-y-3">
                            <h4 class="font-semibold text-gray-900">Informasi Pembayaran</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                                    <p class="mt-1 text-sm">
                                        <span class="px-2 py-1 text-xs rounded-full ${
                                            data.status_pembayaran === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                        }">
                                            ${data.status_pembayaran === 'paid' ? 'Lunas' : 'Pending'}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.midtrans_payment_type || '-'}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                    <p class="mt-1 text-sm text-gray-900">Rp ${data.amount ? parseFloat(data.amount).toLocaleString('id-ID') : '-'}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                                    <p class="mt-1 text-sm text-gray-900">${data.payment_date ? formatDateTime(data.payment_date) : '-'}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                        width: '80%',
                        showCloseButton: true,
                        confirmButtonText: data.already_checked_in ? 'Tutup' : 'Check-in Sekarang',
                        showConfirmButton: !data.already_checked_in,
                        confirmButtonColor: '#9333ea'
                    }).then((result) => {
                        if (result.isConfirmed && !data.already_checked_in) {
                            processManualCheckIn(bibNumber);
                        }
                    });

                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.message || 'Data peserta tidak ditemukan',
                        icon: 'error'
                    });
                }
            } catch (error) {
                console.error('Error fetching peserta data:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal mengambil data peserta',
                    icon: 'error'
                });
            }
        }

        function showParticipantDetails(participant) {
            Swal.fire({
                title: 'Detail Peserta',
                html: `
            <div class="text-left p-4 space-y-4 overflow-y-auto max-h-[70vh]">
                <!-- Data Utama -->
                <div class="grid grid-cols-2 gap-4 pb-3 border-b">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor BIB</label>
                        <p class="mt-1 text-sm text-gray-900">${participant.kode_bib}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1">
                            <span class="status-badge ${participant.is_checked_in ? 'checked-in' : 'not-checked-in'}">
                                ${participant.is_checked_in ? 'Checked In' : 'Pending'}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Informasi Pribadi -->
                <div class="space-y-3 pb-3 border-b">
                    <h4 class="font-semibold text-gray-900">Informasi Pribadi</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.nama_lengkap}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama BIB</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.nama_bib || '-'}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.email}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. WhatsApp</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.no_wa}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Usia</label>
                        <p class="mt-1 text-sm text-gray-900">${participant.usia} tahun</p>
                    </div>
                </div>

                <!-- Alamat -->
                <div class="space-y-3 pb-3 border-b">
                    <h4 class="font-semibold text-gray-900">Alamat</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.provinsi}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kota</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.kota}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.kecamatan}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kelurahan</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.kelurahan}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <p class="mt-1 text-sm text-gray-900">${participant.alamat}</p>
                    </div>
                </div>

                <!-- Informasi Event -->
                <div class="space-y-3 pb-3 border-b">
                    <h4 class="font-semibold text-gray-900">Informasi Event</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Kategori</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.kategori}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ukuran Baju</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.size ? participant.size.name : '-'}</p>
                        </div>
                    </div>
                    ${participant.check_in_time ? `
                                                                                                                                                    <div>
                                                                                                                                                        <label class="block text-sm font-medium text-gray-700">Waktu Check-in</label>
                                                                                                                                                        <p class="mt-1 text-sm text-gray-900">${formatDateTime(participant.check_in_time)}</p>
                                                                                                                                                    </div>
                                                                                                                                                ` : ''}
                </div>

                <!-- Informasi Medis -->
                <div class="space-y-3 pb-3 border-b">
                    <h4 class="font-semibold text-gray-900">Informasi Medis</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.golongan_darah || '-'}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ada Alergi</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.ada_alergi ? 'Ya' : 'Tidak'}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Riwayat Penyakit</label>
                        <p class="mt-1 text-sm text-gray-900">${participant.riwayat_penyakit || '-'}</p>
                    </div>
                </div>

                <!-- Kontak Darurat -->
                <div class="space-y-3 pb-3 border-b">
                    <h4 class="font-semibold text-gray-900">Kontak Darurat</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.emergency_nama || '-'}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.emergency_nomor || '-'}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pembayaran -->
                <div class="space-y-3">
                    <h4 class="font-semibold text-gray-900">Informasi Pembayaran</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                            <p class="mt-1 text-sm">
                                <span class="px-2 py-1 text-xs rounded-full ${
                                    participant.status_pembayaran === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                }">
                                    ${participant.status_pembayaran === 'paid' ? 'Lunas' : 'Pending'}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.midtrans_payment_type || '-'}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <p class="mt-1 text-sm text-gray-900">Rp ${participant.amount ? parseFloat(participant.amount).toLocaleString('id-ID') : '-'}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Pembayaran</label>
                            <p class="mt-1 text-sm text-gray-900">${participant.payment_date ? formatDateTime(participant.payment_date) : '-'}</p>
                        </div>
                    </div>
                </div>
            </div>
        `,
                width: '80%',
                showCloseButton: true,
                confirmButtonText: participant.is_checked_in ? 'Tutup' : 'Check-in Sekarang',
                showConfirmButton: !participant.is_checked_in,
                confirmButtonColor: '#9333ea'
            }).then((result) => {
                if (result.isConfirmed && !participant.is_checked_in) {
                    processManualCheckIn(participant.kode_bib);
                }
            });
        }

        async function processManualCheckIn(bibNumber) {
            try {
                const response = await fetch('/admin/peserta/scan', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        kode_bib: bibNumber
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        title: 'Check-in Berhasil!',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        loadParticipantData();
                    });
                } else {
                    Swal.fire({
                        title: 'Gagal!',
                        text: result.message,
                        icon: 'error'
                    });
                }
            } catch (error) {
                console.error('Error processing manual check-in:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat memproses check-in',
                    icon: 'error'
                });
            }
        }

        // Initialize when page loads
        window.addEventListener('load', async function() {
            initializeElements();
            const hasPermission = await checkCameraPermission();
            if (hasPermission) {
                startCamera();
            }
        });

        // Cleanup when leaving page
        window.addEventListener('beforeunload', function() {
            if (currentStream) {
                currentStream.getTracks().forEach(track => track.stop());
            }
        });
    </script>
@endpush