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
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $snapToken }}', {
                onSuccess: async function(result) {
                    try {
                        // Kirim request untuk update status
                        const response = await fetch('/payment/{{ $peserta->id }}/update-status', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                transaction_status: result.transaction_status,
                                transaction_id: result.transaction_id,
                                payment_type: result.payment_type,
                                gross_amount: result.gross_amount
                            })
                        });

                        if (!response.ok) {
                            throw new Error('Gagal mengupdate status');
                        }

                        // Redirect ke check-order dengan kode BIB
                        window.location.href =
                            '{{ route('check-order.index') }}?kode_bib={{ $peserta->kode_bib }}';
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memproses pembayaran');
                    }
                },
                onPending: function(result) {
                    // Update status ke pending
                    fetch('/payment/{{ $peserta->id }}/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            transaction_status: 'pending',
                            transaction_id: result.transaction_id,
                            payment_type: result.payment_type,
                            gross_amount: result.gross_amount
                        })
                    }).finally(() => {
                        window.location.href =
                            '{{ route('check-order.index') }}?kode_bib={{ $peserta->kode_bib }}';
                    });
                },
                onError: function(result) {
                    // Update status ke failed
                    fetch('/payment/{{ $peserta->id }}/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            transaction_status: 'failed',
                            transaction_id: result.transaction_id,
                            payment_type: result.payment_type,
                            gross_amount: result.gross_amount
                        })
                    }).finally(() => {
                        window.location.href =
                            '{{ route('check-order.index') }}?kode_bib={{ $peserta->kode_bib }}';
                    });
                },
                onClose: function() {
                    // Optional: update status ke cancelled
                    fetch('/payment/{{ $peserta->id }}/update-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content
                        },
                        body: JSON.stringify({
                            transaction_status: 'cancelled'
                        })
                    });
                }
            });
        });
    </script>
@endpush
