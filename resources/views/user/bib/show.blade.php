@extends('layouts.applanding')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-500 to-pink-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Nomor BIB Anda</h2>
                    <p class="text-gray-600 text-lg">Download dan pasang di bagian depan baju saat event</p>
                </div>

                <!-- BIB Card -->
                <div id="bib-card" class="mx-auto bg-white border-2 border-gray-200 relative"
                    style="width: 400px; height: 300px;">
                    <!-- Event Header -->
                    <div class="bg-pink-600 text-white text-center py-2">
                        <h1 class="text-xl font-bold">PARTY COLOR RUN 2024</h1>
                    </div>

                    <!-- BIB Number -->
                    <div class="text-center py-4">
                        <div class="text-[80px] font-black leading-none tracking-wider">
                            {{ $peserta->kode_bib }}
                        </div>
                    </div>

                    <!-- Runner Info -->
                    <div class="text-center">
                        <div class="text-xl font-bold">{{ $peserta->nama_bib }}</div>
                        <div class="text-lg font-semibold text-pink-600">{{ $peserta->kategori }}</div>
                    </div>

                    <!-- QR Code -->
                    <div class="absolute bottom-2 right-2" style="width: 80px; height: 80px;">
                        <div id="qrcode"></div>
                    </div>
                </div>

                <!-- Download Button -->
                <div class="text-center mt-8">
                    <button onclick="downloadBib()"
                        class="bg-pink-600 text-white px-8 py-3 rounded-xl text-lg font-semibold hover:bg-pink-700">
                        Download BIB
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new QRCode(document.getElementById("qrcode"), {
                    text: "{{ route('check-order.index', ['kode_bib' => $peserta->kode_bib]) }}",
                    width: 80,
                    height: 80,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            });

            function downloadBib() {
                const element = document.getElementById('bib-card');
                const options = {
                    scale: 4,
                    useCORS: true,
                    backgroundColor: '#ffffff'
                };

                html2canvas(element, options).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'BIB-{{ $peserta->kode_bib }}.png';
                    link.href = canvas.toDataURL('image/png', 1.0);
                    link.click();
                });
            }
        </script>
    @endpush
@endsection
