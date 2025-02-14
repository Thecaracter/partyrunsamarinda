@extends('layouts.applanding')

@section('content')
    <div class="min-h-screen pt-28 bg-blue-500 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <!-- Header -->
                <h2 class="text-4xl md:text-5xl font-bold text-center mb-10">Rules</h2>

                <!-- Rules Sections -->
                <div class="space-y-10">
                    <!-- Syarat dan Ketentuan -->
                    <div class="bg-gray-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-clipboard-list text-blue-600 mr-3"></i>
                            Syarat dan Ketentuan
                        </h3>
                        <div class="space-y-4 text-gray-700">
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>Peserta kategori 5K PELAJAR harus berusia antara 12 -16 Tahun.</li>
                                <li>Peserta kategori 5K UMUM harus berusia 17 tahun ke atas.</li>

                                <li>Penyelenggara berhak untuk memverifikasi usia peserta sebelum, selama, atau setelah
                                    acara. Pengecualian hanya dapat diberikan dengan persetujuan dari penyelenggara.</li>
                                <li>Pendaftaran ditutup jika kuota peserta sudah penuh.</li>
                                <li>Biaya pendaftaran tidak dapat dikembalikan (non-refundable).</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Pendaftaran -->
                    <div class="bg-pink-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-user-plus text-blue-600 mr-3"></i>
                            Pendaftaran
                        </h3>
                        <div class="space-y-4 text-gray-700">
                            <p>Pendaftaran hanya dapat dilakukan melalui website <a href=""
                                    class="text-pink-600 hover:text-pink-700 underline">www.partycolorbderma.com</a> dengan
                                meng-klik tombol "REGISTER".</p>
                            <div class="mt-4">
                                <p class="font-semibold mb-2">Pilih kategori:</p>
                                <ul class="list-disc list-outside ml-6 space-y-2">
                                    <li>5K PELAJAR: 12-17 tahun</li>
                                    <li>5K UMUM: 17 tahun ke atas</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Pengawasan Rute Lomba -->
                    <div class="bg-blue-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-route text-blue-600 mr-3"></i>
                            Pengawasan Rute Lomba
                        </h3>
                        <div class="space-y-4 text-gray-700">
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>Peserta yang tidak mengikuti arahan petugas atau melakukan tindakan pelecehan, bullying,
                                    provokasi atau hal-hal yang dianggap mengganggu peserta lain akan didiskualifikasi.</li>
                                <li>Peserta yang melakukan tindakan curang seperti memotong rute lomba atau tidak mengenakan
                                    BIB dengan benar akan didiskualifikasi.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Ketentuan Lomba -->
                    <div class="bg-yellow-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-flag-checkered text-blue-600 mr-3"></i>
                            Ketentuan Lomba
                        </h3>
                        <div class="space-y-4 text-gray-700">
                            <ul class="list-disc list-outside ml-6 space-y-3">
                                <li>BIB (nomor dada) tidak dapat dipindahtangankan.</li>
                                <li>Peserta dapat didiskualifikasi jika memberikan informasi yang salah atau mengonsumsi
                                    bahan terlarang.</li>
                                <li>Peserta wajib menghentikan lomba jika diminta oleh petugas atau tim medis.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Informasi Penting -->
                    <div class="bg-red-50 rounded-xl p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-exclamation-circle text-blue-600 mr-3"></i>
                            Informasi Penting
                        </h3>
                        <div class="text-gray-700">
                            <p>
                                Peserta diharuskan membaca semua pemberitahuan, peraturan lomba, dan syarat ketentuan
                                sebelum mendaftar.
                                Dengan mendaftar, peserta dianggap setuju dengan semua syarat dan ketentuan.
                                <!-- Menambahkan link ke file Terms and Conditions PDF -->
                                <br>
                                <a href="https://drive.google.com/file/d/1qx19LOIo55rgfGh7aHPirM2PfvmO3Dmj/view?usp=sharing"
                                    target="_blank" class="text-blue-600 underline">
                                    Klik di sini untuk mengunduh Syarat dan Ketentuan (PDF)
                                </a>
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Register Button -->
            <div class="mt-12 text-center">
                <a href="{{ route('registrasi.index') }}"
                    class="inline-block bg-blue-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
    </div>
@endsection
