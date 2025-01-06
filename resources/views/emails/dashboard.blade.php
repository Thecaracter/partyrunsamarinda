@extends('layouts.applanding')

@section('title', 'Email Dashboard')
@section('header', 'Email Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-xl p-6">
            <!-- Control Buttons -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Pengiriman Email</h2>
                <div class="space-x-4">
                    <button id="blastButton" onclick="startEmailBlast()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Kirim Email Halaman Ini
                    </button>
                    <button id="stopButton" disabled
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50">
                        Stop
                    </button>
                    <button onclick="clearConsole()" class="px-4 py-2 text-gray-700 hover:text-gray-900">
                        Clear Log
                    </button>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-blue-600 h-2.5 rounded-full w-0 transition-all duration-300"></div>
                </div>
                <div class="mt-2 text-sm text-gray-600 text-center" id="progressText">0%</div>
            </div>

            <!-- Console Output -->
            <div id="console" class="h-[400px] overflow-auto bg-gray-900 rounded-xl p-4 font-mono text-sm"></div>

            <!-- Daftar Peserta -->
            <div class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center space-x-4">
                        <h3 class="text-lg font-semibold text-gray-800">Daftar Peserta</h3>
                        <span class="text-sm text-gray-600">
                            Menampilkan {{ $pesertaDenganBib->firstItem() ?? 0 }} -
                            {{ $pesertaDenganBib->lastItem() ?? 0 }} dari
                            {{ $pesertaDenganBib->total() ?? 0 }} peserta
                        </span>
                    </div>

                    <!-- Search Form -->
                    <form method="GET" action="{{ url('/admin/email') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari nama/email/kode BIB..."
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                        @if ($search)
                            <a href="{{ url('/admin/email') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                <i class="fas fa-times mr-2"></i> Reset
                            </a>
                        @endif
                    </form>
                </div>

                <div class="overflow-hidden rounded-xl border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kode BIB</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pesertaDenganBib as $peserta)
                                <tr id="peserta-row-{{ $peserta->id }}">
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $peserta->nama_lengkap }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ $peserta->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-500">{{ $peserta->kode_bib }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button onclick="sendSingleEmail({{ $peserta->id }})"
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm">
                                            <i class="fas fa-envelope mr-1"></i> Kirim
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data peserta yang ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $pesertaDenganBib->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const consoleDiv = document.getElementById('console');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');

            function updateProgress(percentage) {
                progressBar.style.width = `${percentage}%`;
                progressText.textContent = `${percentage}%`;
            }

            function log(message, type = 'info') {
                const timestamp = new Date().toLocaleTimeString();
                const logEntry = document.createElement('div');
                logEntry.className = `text-sm mb-1 ${type === 'error' ? 'text-red-400' : 'text-green-400'}`;
                logEntry.textContent = `[${timestamp}] ${message}`;
                consoleDiv.appendChild(logEntry);
                consoleDiv.scrollTop = consoleDiv.scrollHeight;
            }

            function clearConsole() {
                consoleDiv.innerHTML = '';
                updateProgress(0);
            }

            async function sendSingleEmail(pesertaId) {
                const row = document.getElementById(`peserta-row-${pesertaId}`);
                const button = row.querySelector('button');
                const originalText = button.innerHTML;
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';

                try {
                    const response = await fetch('/admin/email/send-single', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            peserta_id: pesertaId
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        log(`✅ Email berhasil dikirim ke ${data.log.email}`);
                        button.innerHTML = '<i class="fas fa-check"></i> Terkirim';
                        button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                        button.classList.add('bg-green-600', 'hover:bg-green-700');
                    } else {
                        log(`❌ Gagal mengirim email ke ${data.log.email}: ${data.log.error}`, 'error');
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }
                } catch (error) {
                    log(`❌ Error sistem: ${error.message}`, 'error');
                    button.innerHTML = originalText;
                    button.disabled = false;
                }
            }

            function startEmailBlast() {
                const button = document.getElementById('blastButton');
                const stopButton = document.getElementById('stopButton');
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
                stopButton.disabled = false;

                // Get current page from URL
                const urlParams = new URLSearchParams(window.location.search);
                const currentPage = urlParams.get('page') || 1;
                const searchQuery = urlParams.get('search') || '';

                let eventSource;

                function stopBlast() {
                    if (eventSource) {
                        eventSource.close();
                        log('⛔ Pengiriman email dihentikan manual', 'error');
                        button.disabled = false;
                        button.innerHTML = 'Kirim Email Halaman Ini';
                        stopButton.disabled = true;
                        updateProgress(0);
                    }
                }

                log('🚀 Memulai pengiriman email untuk halaman ' + currentPage);

                eventSource = new EventSource(`/admin/email/blast?page=${currentPage}&search=${searchQuery}`);

                eventSource.onmessage = function(event) {
                    const data = JSON.parse(event.data);

                    if (data.status === 'success') {
                        log(`✅ Email berhasil dikirim ke ${data.email}`);
                        updateProgress(data.percentage);
                    } else if (data.status === 'failed') {
                        log(`❌ Gagal mengirim email ke ${data.email}: ${data.error}`, 'error');
                        updateProgress(data.percentage);
                    } else if (data.status === 'completed') {
                        log(`✨ ${data.message}`);
                        log(`📊 Total terkirim: ${data.totalSent}, Gagal: ${data.totalFailed}`);
                        eventSource.close();
                        button.disabled = false;
                        button.innerHTML = 'Kirim Email Halaman Ini';
                        stopButton.disabled = true;
                    }
                };

                eventSource.onerror = function() {
                    eventSource.close();
                    button.disabled = false;
                    button.innerHTML = 'Kirim Email Halaman Ini';
                    stopButton.disabled = true;
                };

                document.getElementById('stopButton').onclick = stopBlast;
            }
        </script>
    @endpush
@endsection
