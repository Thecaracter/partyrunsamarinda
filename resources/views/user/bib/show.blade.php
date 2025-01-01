@extends('layouts.applanding')

@section('title', 'Download BIB')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Nomor BIB Anda</h2>
                    <p class="text-gray-600 text-lg">Download dan pasang di bagian depan baju saat event</p>
                </div>

                <div class="mx-auto" style="max-width: 600px;">
                    <div id="bib-card" class="relative w-full bg-white border-2 border-yellow-400 rounded-lg overflow-hidden"
                        style="aspect-ratio: 16/10;">
                        <div class="h-2/3 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>

                        <div class="absolute top-0 left-0 w-full h-full flex flex-col">
                            <div class="bg-white h-16 px-4 flex justify-between items-center border-b-2 border-yellow-400">
                                <div class="flex gap-4">
                                    <img src="{{ asset('Images/logo_dyza.png') }}" class="h-12">
                                    <img src="{{ asset('Images/logo_dyza.png') }}" class="h-12">
                                </div>
                                <img src="{{ asset('Images/1.png') }}" class="h-12">
                            </div>

                            <div class="flex-1 flex items-center justify-center">
                                <div class="text-center flex flex-col items-center">
                                    <div class="flex flex-col items-center">
                                        <div class="text-[100px] font-black text-black mt-[-40px]">
                                            {{ str_pad($peserta->kode_bib, 3, '0', STR_PAD_LEFT) }}
                                        </div>

                                        <div class="text-xl font-bold text-black lowercase -mt-[30px]">
                                            {{ $peserta->nama_bib }}
                                        </div>
                                    </div>

                                    <div class="mt-[10px]">
                                        <span class="text-4xl font-bold text-white">
                                            {{ $peserta->kategori }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white h-28 px-6 py-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="mb-3 text-sm">
                                            Blood Type: {{ $peserta->golongan_darah }} | Emergency:
                                            {{ $peserta->emergency_nama }} ({{ $peserta->emergency_nomor }})
                                        </div>
                                        <div class="flex gap-8">
                                            <label class="flex items-center gap-2">
                                                <div class="w-4 h-4 border-2 border-black"></div>
                                                <span class="text-sm">Medal</span>
                                            </label>
                                            <label class="flex items-center gap-2">
                                                <div class="w-4 h-4 border-2 border-black"></div>
                                                <span class="text-sm">Refreshment</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="font-bold italic text-lg {{ $peserta->kategori == 'Pelajar'
                                                ? 'text-pink-500'
                                                : ($peserta->kategori == 'Umum'
                                                    ? 'text-purple-500'
                                                    : 'text-blue-500') }}">
                                            {{ strtolower($peserta->kategori) }}-5km
                                        </span>
                                        <div id="qrcode" class="w-16 h-16"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <button onclick="downloadBib()"
                        class="bg-gradient-to-r from-pink-500 to-purple-500 text-white px-8 py-3 rounded-xl text-lg font-semibold hover:from-pink-600 hover:to-purple-600 transition-all duration-200 shadow-lg">
                        Download BIB
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new QRCode(document.getElementById("qrcode"), {
                    text: "{{ route('check-order.index', ['kode_bib' => $peserta->kode_bib]) }}",
                    width: 64,
                    height: 64,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });
            });

            function downloadBib() {
                const element = document.getElementById('bib-card');

                domtoimage.toBlob(element)
                    .then(function(blob) {
                        const url = URL.createObjectURL(blob);
                        const link = document.createElement('a');
                        link.download = 'BIB-{{ str_pad($peserta->kode_bib, 3, '0', STR_PAD_LEFT) }}.png';
                        link.href = url;
                        link.click();
                        URL.revokeObjectURL(url);
                    })
                    .catch(function(error) {
                        console.error('Error generating BIB:', error);
                        alert('Terjadi kesalahan saat men-download BIB. Silakan coba lagi.');
                    });
            }
        </script>
    @endpush
@endsection
