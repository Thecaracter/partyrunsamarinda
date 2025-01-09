{{-- resources/views/payment/show.blade.php --}}
@extends('layouts.applanding')

@section('content')
    <div class="min-h-screen pt-28 bg-gradient-to-br from-purple-500 via-pink-500 to-red-500">
        <div class="container mx-auto px-4 py-12">
            <!-- Payment Card -->
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-pink-500 to-purple-600 p-8">
                        <h2 class="text-3xl font-bold text-white text-center mb-2">Pembayaran Registrasi</h2>
                        <p class="text-pink-100 text-center">Party Color Run</p>
                    </div>

                    <!-- Payment Details -->
                    <div class="p-8">
                        <!-- Order Summary -->
                        <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Detail Peserta</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nama</span>
                                    <span class="font-medium text-gray-800">{{ $peserta->nama_lengkap }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Email</span>
                                    <span class="font-medium text-gray-800">{{ $peserta->email }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. WhatsApp</span>
                                    <span class="font-medium text-gray-800">{{ $peserta->no_wa }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kategori</span>
                                    <span class="font-medium text-gray-800">{{ $peserta->kategori }}</span>
                                </div>
                                <hr class="my-4 border-gray-200">
                                <div class="flex justify-between text-lg font-bold">
                                    <span class="text-gray-800">Total Pembayaran</span>
                                    <span class="text-pink-600">Rp {{ number_format($peserta->amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Buttons -->
                        <div class="text-center space-y-4">
                            <button id="pay-button"
                                class="w-full bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold py-4 px-8 rounded-xl hover:from-pink-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                Bayar Sekarang
                            </button>
                            <!-- Tombol untuk membuka kembali popup yang tertutup -->
                            <button id="reopen-payment"
                                class="w-full bg-white border-2 border-pink-500 text-pink-500 font-bold py-4 px-8 rounded-xl hover:bg-pink-50 transition-all duration-300 hidden">
                                Buka Kembali Pembayaran
                            </button>
                            <p class="mt-4 text-sm text-gray-500">
                                Anda akan diarahkan ke halaman pembayaran yang aman
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 p-6 border-t border-gray-100">
                        <div class="flex items-center justify-center space-x-4">
                            <i class="fas fa-lock text-gray-400"></i>
                            <span class="text-sm text-gray-500">Pembayaran Aman & Terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    {{-- Loading Overlay HTML --}}
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[60]">
        <div class="text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-white"></div>
            <p class="mt-2 text-white font-semibold">Mohon tunggu...</p>
        </div>
    </div>

    {{-- Payment Alert dengan scroll --}}
    <div id="paymentAlert"
        class="fixed top-0 left-0 right-0 bottom-0 z-50 transform -translate-y-full transition-transform duration-500 bg-white/95 overflow-y-auto">
        <!-- Menggunakan padding yang responsif -->
        <div class="max-w-4xl mx-auto bg-white border-l-4 border-yellow-400 rounded-b-xl shadow-2xl m-2 sm:m-4">
            <div class="p-3 sm:p-4 md:p-6">
                <!-- Flex container utama -->
                <div class="flex flex-col sm:flex-row items-start">
                    <!-- Icon - Hidden di mobile, tampil di desktop -->
                    <div class="hidden sm:block flex-shrink-0">
                        <div class="bg-yellow-100 p-3 rounded-full sticky top-4">
                            <svg class="h-6 w-6 sm:h-8 sm:w-8 text-yellow-500" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Main Content dengan spacing responsif -->
                    <div class="w-full sm:ml-4 flex-grow">
                        <!-- Header dengan ukuran font responsif -->
                        <div class="flex items-center justify-between mb-4 sticky top-0 bg-white z-10 py-2">
                            <h3 class="text-lg sm:text-xl font-bold text-yellow-800 flex items-center">
                                <span>🎫 Panduan & Persiapan Pembayaran</span>
                            </h3>
                            <!-- Close button untuk mobile -->
                            <button id="closeAlert"
                                class="sm:hidden text-gray-400 hover:text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-full p-2">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Grid yang responsif -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 sm:gap-4">
                            <!-- Left Column -->
                            <div class="space-y-3 sm:space-y-4">
                                <!-- Waktu & Peringatan -->
                                <div
                                    class="bg-gradient-to-r from-red-50 to-red-100 p-3 sm:p-4 rounded-xl border border-red-200 shadow-sm">
                                    <p
                                        class="font-bold text-red-700 text-base sm:text-lg flex flex-wrap items-center gap-2">
                                        ⚠️ PENTING!
                                        <span
                                            class="text-xs sm:text-sm bg-red-200 text-red-800 px-2 sm:px-3 py-1 rounded-full">Harap
                                            Dibaca</span>
                                    </p>
                                    <ul class="list-none mt-2 text-xs sm:text-sm text-red-600 space-y-2">
                                        <li class="flex items-center">
                                            <span class="mr-2">⏰</span>
                                            <span>Waktu pembayaran hanya <span
                                                    class="font-bold bg-red-200 px-2 py-0.5 rounded">5 MENIT!</span></span>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">⛔</span>
                                            <span>JANGAN tutup halaman website ini</span>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">🚫</span>
                                            <span>JANGAN bersihkan/clear data browser</span>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">📱</span>
                                            <span>Jika menggunakan HP, biarkan browser tetap aktif</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Persiapan -->
                                <div
                                    class="bg-gradient-to-r from-yellow-50 to-yellow-100 p-3 sm:p-4 rounded-xl border border-yellow-200 shadow-sm">
                                    <p class="font-semibold text-yellow-800 text-base sm:text-lg">
                                        ✅ Checklist Persiapan
                                    </p>
                                    <ul class="list-none mt-2 text-xs sm:text-sm text-yellow-700 space-y-2">
                                        <li class="flex items-center">
                                            <span class="mr-2">📱</span>
                                            <span>Aplikasi m-banking sudah terbuka & siap</span>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">🏧</span>
                                            <span>Dekat dengan ATM (jika bayar via ATM)</span>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">💰</span>
                                            <span>Saldo mencukupi untuk pembayaran</span>
                                        </li>
                                        <li class="flex items-center">
                                            <span class="mr-2">📶</span>
                                            <span>Koneksi internet stabil & lancar</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-3 sm:space-y-4">
                                <!-- Panduan -->
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-blue-100 p-3 sm:p-4 rounded-xl border border-blue-200 shadow-sm">
                                    <p class="font-semibold text-blue-800 text-base sm:text-lg">
                                        📝 Langkah Pembayaran
                                    </p>
                                    <ul class="list-none mt-2 text-xs sm:text-sm text-blue-700 space-y-2">
                                        <li class="flex items-start">
                                            <span class="mr-2 font-bold">1.</span>
                                            <span>Klik tombol "Saya Siap, Lanjutkan" di bawah</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-2 font-bold">2.</span>
                                            <span>Pilih metode pembayaran yang tersedia</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-2 font-bold">3.</span>
                                            <span>Ikuti petunjuk pembayaran dengan teliti</span>
                                        </li>
                                        <li class="flex items-start">
                                            <span class="mr-2 font-bold">4.</span>
                                            <span>Selesaikan pembayaran dalam 5 menit</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Catatan -->
                                <div
                                    class="bg-gradient-to-r from-gray-50 to-gray-100 p-3 sm:p-4 rounded-xl border border-gray-200 shadow-sm">
                                    <p class="font-semibold text-gray-700 text-base sm:text-lg mb-2">
                                        💡 Catatan Penting
                                    </p>
                                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                        Jika halaman tertutup tidak sengaja, Anda dapat membuka kembali melalui riwayat
                                        browser atau tab yang masih aktif. Namun ingat, batas waktu 5 menit tetap berjalan!
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Button Section -->
                        <div class="mt-4 sm:mt-6 sticky bottom-0 bg-white pt-4 pb-2 z-10">
                            <button id="proceedPayment"
                                class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-4 sm:px-8 py-3 sm:py-4 rounded-xl text-base sm:text-lg font-bold transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center">
                                <span>Saya Siap, Lanjutkan Pembayaran</span>
                                <svg class="ml-2 h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Close Button - Hidden di mobile -->
                    <div class="hidden sm:block ml-4">
                        <button id="closeAlert"
                            class="text-gray-400 hover:text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-full p-2 transition-colors duration-200 sticky top-4">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (config('midtrans.is_production'))
        <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.current_client_key') }}">
        </script>
    @else
        <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.current_client_key') }}"></script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const payButton = document.querySelector('#pay-button');
            const loadingOverlay = document.querySelector('#loadingOverlay');
            const paymentAlert = document.querySelector('#paymentAlert');
            const closeAlert = document.querySelector('#closeAlert');
            const proceedPayment = document.querySelector('#proceedPayment');
            let currentStatus = 'initial';
            let isProcessing = false;

            function disablePaymentButtons() {
                if (payButton) {
                    payButton.disabled = true;
                    payButton.classList.add('opacity-50', 'cursor-not-allowed');
                    payButton.innerHTML = 'Sedang Memproses...';
                }
                if (proceedPayment) {
                    proceedPayment.disabled = true;
                    proceedPayment.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }

            function showLoading() {
                if (loadingOverlay) {
                    loadingOverlay.classList.remove('hidden');
                    loadingOverlay.classList.add('flex');
                }
            }

            function hideLoading() {
                if (loadingOverlay) {
                    loadingOverlay.classList.add('hidden');
                    loadingOverlay.classList.remove('flex');
                }
            }

            function showAlert() {
                if (isProcessing) return; // Cek jika sedang proses
                paymentAlert.classList.remove('-translate-y-full');
                paymentAlert.classList.add('translate-y-0');
                paymentAlert.scrollTo(0, 0);
            }

            function hideAlert() {
                paymentAlert.classList.remove('translate-y-0');
                paymentAlert.classList.add('-translate-y-full');
            }

            function initializePayment() {
                if (isProcessing) return; // Cek jika sedang proses

                isProcessing = true;
                disablePaymentButtons();
                hideAlert();
                showLoading();

                // Langsung tampilkan popup Midtrans tanpa delay
                snap.pay('{{ $snapToken }}', {
                    skipOrderSummary: true,
                    onSuccess: async function(result) {
                        try {
                            window.location.href =
                                '{{ route('check-order.index') }}?kode_bib={{ $peserta->kode_bib }}';
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan saat memproses pembayaran');
                        }
                    },
                    onPending: async function(result) {
                        currentStatus = 'pending';
                        await updateStatus('pending', result);
                    },
                    onError: async function(result) {
                        currentStatus = 'failed';
                        await updateStatus('failed', result);
                    },
                    onClose: function() {

                    }
                });
            }

            // Event Listeners
            if (payButton) {
                payButton.addEventListener('click', function(e) {
                    if (isProcessing) return;
                    e.preventDefault();
                    showAlert();
                });
            }

            if (proceedPayment) {
                proceedPayment.addEventListener('click', function(e) {
                    if (isProcessing) return;
                    initializePayment();
                });
            }

            if (closeAlert) {
                closeAlert.addEventListener('click', hideAlert);
            }

            // Handle scroll
            const header = document.querySelector('.sticky');
            paymentAlert.addEventListener('scroll', function() {
                if (header && paymentAlert.scrollTop > 0) {
                    header.classList.add('shadow-md');
                } else if (header) {
                    header.classList.remove('shadow-md');
                }
            });

            async function updateStatus(status, result = {}) {
                showLoading();
                try {
                    const response = await fetch('/payment/{{ $peserta->id }}/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            transaction_status: status,
                            transaction_id: result.transaction_id,
                            payment_type: result.payment_type,
                            gross_amount: result.gross_amount
                        })
                    });

                    if (!response.ok) throw new Error('Gagal mengupdate status');

                    if (status !== 'cancelled') {
                        window.location.href =
                            '{{ route('check-order.index') }}?kode_bib={{ $peserta->kode_bib }}';
                    }
                } catch (error) {
                    console.error('Error updating status:', error);
                    alert('Terjadi kesalahan saat mengupdate status');
                } finally {
                    hideLoading();
                }
            }
        });
    </script>
@endpush
