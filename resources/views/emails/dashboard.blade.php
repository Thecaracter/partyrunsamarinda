@extends('layouts.applanding')

@section('title', 'Email Dashboard')
@section('header', 'Email Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="bg-white/80 backdrop-blur-sm shadow-lg rounded-xl p-6">
            <!-- Control Buttons -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Pengiriman Email</h2>
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Pengiriman Email</h2>
                    <div class="space-x-4">
                        <button id="blastButton" onclick="startEmailBlast()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Kirim Semua
                        </button>
                        <button id="stopButton" disabled
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50">
                            Stop
                        </button>
                        <button onclick="clearConsole()" class="px-4 py-2 text-gray-700 hover:text-gray-900">
                            Clear
                        </button>
                    </div>
                </div>
            </div>

            <!-- Console Output -->
            <div id="console" class="h-[400px] overflow-auto bg-black rounded-xl p-4 font-mono text-sm"></div>

            <!-- Daftar Peserta -->
            <div class="mt-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Peserta</h3>

                    <!-- Search Form -->
                    <form method="GET" action="{{ url('/admin/email') }}" class="flex gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari nama/email/kode BIB..."
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Cari
                        </button>
                        @if ($search)
                            <a href="{{ url('/admin/email') }}"
                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Reset
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
                                <tr>
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
                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Kirim Email
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

            function log(message) {
                const timestamp = new Date().toLocaleTimeString();
                const logEntry = document.createElement('div');
                logEntry.className = 'text-white mb-1';
                logEntry.textContent = `[${timestamp}] ${message}`;
                consoleDiv.appendChild(logEntry);
                consoleDiv.scrollTop = consoleDiv.scrollHeight;
            }

            function clearConsole() {
                consoleDiv.innerHTML = '';
            }

            async function sendSingleEmail(pesertaId) {
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
                    } else {
                        log(`❌ Gagal mengirim email ke ${data.log.email}: ${data.log.error}`);
                    }
                } catch (error) {
                    log(`❌ Error sistem: ${error.message}`);
                }
            }

            function startEmailBlast() {
                const button = document.getElementById('blastButton');
                const stopButton = document.getElementById('stopButton');
                button.disabled = true;
                button.textContent = 'Mengirim...';
                stopButton.disabled = false;

                let eventSource;

                function stopBlast() {
                    if (eventSource) {
                        eventSource.close();
                        log('⛔ Pengiriman email dihentikan manual');
                        button.disabled = false;
                        button.textContent = 'Kirim Semua';
                        stopButton.disabled = true;
                    }
                }

                log('Memulai pengiriman email ke semua peserta...');

                eventSource = new EventSource('/admin/email/blast');

                eventSource.onmessage = function(event) {
                    const data = JSON.parse(event.data);

                    if (data.status === 'pause') {
                        log(`⏸️ ${data.message}`);
                        log(`📊 Total terkirim: ${data.totalSent}, Sisa: ${data.remaining}`);
                    } else if (data.status === 'success') {
                        log(`✅ Email berhasil dikirim ke ${data.email}`);
                        log(`📊 Total terkirim: ${data.totalSent}, Sisa: ${data.remaining}`);
                    } else {
                        log(`❌ Gagal mengirim email ke ${data.email}: ${data.error}`);
                        log(`📊 Total terkirim: ${data.totalSent}, Sisa: ${data.remaining}`);
                    }
                };

                eventSource.onerror = function() {
                    log('Pengiriman email selesai');
                    eventSource.close();
                    button.disabled = false;
                    button.textContent = 'Kirim Semua';
                    stopButton.disabled = true;
                };

                document.getElementById('stopButton').onclick = stopBlast;
            }
        </script>
    @endpush
@endsection
