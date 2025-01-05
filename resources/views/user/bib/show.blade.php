@extends('layouts.applanding')

@section('title', 'Download BIB')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Nomor BIB Anda</h2>
                    <p class="text-gray-600 text-lg"></p>
                </div>

                <div class="mx-auto" style="max-width: 600px;">
                    <!-- Mobile version (shown only on small screens) -->
                    <div class="sm:hidden">
                        <div id="bib-card-mobile"
                            class="relative w-full bg-white border-2 border-yellow-400 rounded-lg overflow-hidden"
                            style="aspect-ratio: 16/10;">
                            <!-- Header with logos -->
                            <div class="bg-white h-12 px-3 flex justify-between items-center">
                                <div class="flex gap-2">
                                    <img src="{{ asset('Images/logobderma.png') }}" class="h-8">
                                    <img src="{{ asset('Images/logo_dyza.png') }}" class="h-8">
                                </div>
                                <img src="{{ asset('Images/1.png') }}" class="h-8">
                            </div>

                            <!-- Gradient background with number -->
                            <div
                                class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 h-[calc(100%-4.5rem)] flex flex-col items-center justify-center mb-[20px]">
                                <div class="text-[40px] font-bold text-white leading-none">
                                    {{ str_pad($peserta->kode_bib, 3, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="text-base font-bold text-white lowercase mt-[-8px]">
                                    {{ $peserta->nama_bib }}
                                </div>
                                <div class="mt-[-5px]">
                                    <span class="text-base font-bold text-white lowercase">
                                        {{ $peserta->kategori }}
                                    </span>
                                </div>
                                <br>
                            </div>

                            <!-- Footer -->
                            <div class="absolute bottom-0 w-full bg-white h-[40px] px-3">
                                <div class="flex justify-between items-start h-full py-2">
                                    <div>
                                        <div class="text-[8px] mb-1">
                                            Blood Type: {{ $peserta->golongan_darah }} | Emergency:
                                            {{ $peserta->emergency_nama }} ({{ $peserta->emergency_nomor }})
                                        </div>
                                        <div class="flex gap-4">
                                            <label class="flex items-center gap-1">
                                                <div class="w-2 h-2 border-[1px] border-black"></div>
                                                <span class="text-[8px]">Medal</span>
                                            </label>
                                            <label class="flex items-center gap-1">
                                                <div class="w-2 h-2 border-[1px] border-black"></div>
                                                <span class="text-[8px]">Refreshment</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold italic text-[8px] text-pink-500">
                                            {{ strtolower($peserta->kategori) }}-5km
                                        </span>
                                        <div id="qrcode-mobile" class="w-4 h-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Desktop version (hidden on small screens) -->
                    <div class="hidden sm:block">
                        <div id="bib-card"
                            class="relative w-full bg-white border-2 border-yellow-400 rounded-lg overflow-hidden"
                            style="aspect-ratio: 16/10;">
                            <div class="h-2/3 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>

                            <div class="absolute top-0 left-0 w-full h-full flex flex-col">
                                <div
                                    class="bg-white h-16 px-4 flex justify-between items-center border-b-2 border-yellow-400">
                                    <div class="flex gap-4">
                                        <img src="{{ asset('Images/logobderma.png') }}" class="h-12">
                                        <img src="{{ asset('Images/logo_dyza.png') }}" class="h-12">
                                    </div>
                                    <img src="{{ asset('Images/1.png') }}" class="h-12">
                                </div>

                                <div class="flex-1 flex items-center justify-center">
                                    <div class="text-center flex flex-col items-center">
                                        <div class="flex flex-col items-center">
                                            <div class="text-[100px] font-bold text-white mt-[-40px]">
                                                {{ str_pad($peserta->kode_bib, 3, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div class="text-xl font-bold text-white uppercase -mt-[30px]">
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
                                                class="font-bold italic text-lg {{ $peserta->kategori == 'Pelajar' ? 'text-pink-500' : 'text-purple-500' }}">
                                                {{ strtolower($peserta->kategori) }}-5km
                                            </span>
                                            <div id="qrcode" class="w-16 h-16"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <button onclick="downloadBib()"
                        class="w-full sm:w-auto bg-gradient-to-r from-pink-500 to-purple-500 text-white px-8 py-3 rounded-xl text-lg font-semibold hover:from-pink-600 hover:to-purple-600 transition-all duration-200 shadow-lg">
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
                // Generate QR code untuk desktop
                new QRCode(document.getElementById("qrcode"), {
                    text: "{{ route('check-order.index', ['kode_bib' => $peserta->kode_bib]) }}",
                    width: 64,
                    height: 64,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                });

                // Generate QR code untuk mobile view (bukan untuk download)
                if (document.getElementById("qrcode-mobile")) {
                    new QRCode(document.getElementById("qrcode-mobile"), {
                        text: "{{ route('check-order.index', ['kode_bib' => $peserta->kode_bib]) }}",
                        width: 16,
                        height: 16,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }
            });

            async function downloadBib() {
                try {
                    // Selalu gunakan versi desktop untuk download
                    const desktopCard = document.getElementById('bib-card');
                    let elementToCapture;

                    // Jika di mobile, clone desktop version dan set display block
                    if (window.innerWidth < 640) {
                        const clone = desktopCard.cloneNode(true);
                        clone.classList.remove('hidden');
                        clone.classList.add('block');
                        clone.id = 'bib-card-temp';
                        clone.style.position = 'fixed';
                        clone.style.top = '-9999px';
                        clone.style.left = '-9999px';
                        document.body.appendChild(clone);

                        // Generate QR code untuk clone
                        new QRCode(clone.querySelector('#qrcode'), {
                            text: "{{ route('check-order.index', ['kode_bib' => $peserta->kode_bib]) }}",
                            width: 64,
                            height: 64,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });

                        // Tunggu sebentar agar QR code ter-generate
                        await new Promise(resolve => setTimeout(resolve, 100));
                        elementToCapture = clone;
                    } else {
                        elementToCapture = desktopCard;
                    }

                    const blob = await domtoimage.toBlob(elementToCapture, {
                        scale: 2,
                        quality: 1,
                        bgcolor: '#ffffff',
                        style: {
                            transform: 'scale(1)',
                            transformOrigin: 'top left'
                        }
                    });

                    // Cleanup jika ada clone
                    if (window.innerWidth < 640) {
                        document.getElementById('bib-card-temp').remove();
                    }

                    // Download file
                    const url = URL.createObjectURL(blob);
                    const link = document.createElement('a');
                    link.download = 'BIB-{{ str_pad($peserta->kode_bib, 3, '0', STR_PAD_LEFT) }}.png';
                    link.href = url;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                    URL.revokeObjectURL(url);
                } catch (error) {
                    console.error('Error generating BIB:', error);
                    alert('Terjadi kesalahan saat men-download BIB. Silakan coba lagi.');
                }
            }
        </script>
    @endpush
@endsection
