@extends('layouts.applanding')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-pink-500 to-pink-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <!-- Header -->
                <div class="text-center mb-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Check Order</h2>
                    <p class="text-gray-600 text-lg">Masukkan kode BIB untuk melihat detail pendaftaran Anda</p>
                </div>

                <!-- Payment Status Alert -->
                @if ($peserta && in_array($peserta->status_pembayaran, ['pending', 'expired', 'failed']))
                    <div class="max-w-2xl mx-auto mb-8">
                        @if ($peserta->status_pembayaran === 'pending')
                            <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
                                <p class="font-bold">Menunggu Pembayaran</p>
                                <p>Silakan lanjutkan pembayaran Anda</p>
                                <div class="mt-4">
                                    <a href="{{ route('payment.show', $peserta->id) }}"
                                        class="inline-block bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition-colors">
                                        Lanjutkan Pembayaran
                                    </a>
                                </div>
                            </div>
                        @elseif ($peserta->status_pembayaran === 'expired')
                            <div class="bg-red-100 text-red-800 p-4 rounded-lg">
                                <p class="font-bold">Pembayaran Kedaluwarsa</p>
                                <p>Silakan lakukan pembayaran ulang</p>
                                <div class="mt-4">
                                    <a href="{{ route('payment.show', $peserta->id) }}"
                                        class="inline-block bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        Bayar Ulang
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="bg-red-100 text-red-800 p-4 rounded-lg">
                                <p class="font-bold">Pembayaran Gagal</p>
                                <p>Silakan lakukan pembayaran ulang</p>
                                <div class="mt-4">
                                    <a href="{{ route('payment.show', $peserta->id) }}"
                                        class="inline-block bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600 transition-colors">
                                        Bayar Ulang
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Search Form -->
                <form action="{{ route('check-order.index') }}" method="GET" class="max-w-2xl mx-auto space-y-6 mb-10">
                    <div>
                        <label class="block text-gray-700 text-lg font-semibold mb-2">
                            Kode BIB
                        </label>
                        <input type="text" name="kode_bib" value="{{ request('kode_bib') }}"
                            class="w-full h-14 px-4 rounded-xl border-2 border-gray-300 focus:border-pink-500 focus:ring focus:ring-pink-200 transition duration-200"
                            placeholder="Masukkan kode BIB Anda">
                    </div>

                    <button type="submit"
                        class="w-full bg-pink-600 text-white py-4 rounded-xl text-lg font-semibold hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                        Cek Status
                    </button>
                </form>

                @if ($peserta)
                    <!-- Detail Info -->
                    <div class="border-t pt-10">
                        <!-- Status Pembayaran -->
                        <div class="mb-8">
                            <div class="flex items-center justify-center space-x-4">
                                @switch($peserta->status_pembayaran)
                                    @case('paid')
                                        <div class="bg-green-100 text-green-800 px-6 py-3 rounded-full text-lg font-semibold">
                                            Pembayaran Lunas
                                        </div>
                                    @break

                                    @case('pending')
                                        <div class="bg-yellow-100 text-yellow-800 px-6 py-3 rounded-full text-lg font-semibold">
                                            Menunggu Pembayaran
                                        </div>
                                    @break

                                    @case('expired')
                                        <div class="bg-red-100 text-red-800 px-6 py-3 rounded-full text-lg font-semibold">
                                            Pembayaran Kedaluwarsa
                                        </div>
                                    @break

                                    @default
                                        <div class="bg-red-100 text-red-800 px-6 py-3 rounded-full text-lg font-semibold">
                                            Pembayaran Gagal
                                        </div>
                                @endswitch
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Personal Info -->
                            <div class="space-y-6">
                                <h3 class="text-xl font-bold text-gray-900 border-b pb-2">Data Diri</h3>

                                <div>
                                    <p class="text-gray-600">Nama Lengkap</p>
                                    <p class="font-semibold">{{ $peserta->nama_lengkap }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Nama BIB</p>
                                    <p class="font-semibold">{{ $peserta->nama_bib }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Email</p>
                                    <p class="font-semibold">{{ $peserta->email }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">No. WhatsApp</p>
                                    <p class="font-semibold">{{ $peserta->no_wa }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Usia</p>
                                    <p class="font-semibold">{{ $peserta->usia }} Tahun</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Kategori</p>
                                    <p class="font-semibold">{{ $peserta->kategori }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Ukuran Jersey</p>
                                    <p class="font-semibold">{{ $peserta->size->name }}</p>
                                </div>

                                <!-- Medical Info -->
                                <div>
                                    <p class="text-gray-600">Golongan Darah</p>
                                    <p class="font-semibold">{{ $peserta->golongan_darah }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Memiliki Alergi</p>
                                    <p class="font-semibold">{{ $peserta->ada_alergi ? 'Ya' : 'Tidak' }}</p>
                                </div>

                                @if ($peserta->riwayat_penyakit)
                                    <div>
                                        <p class="text-gray-600">Riwayat Penyakit</p>
                                        <p class="font-semibold">{{ $peserta->riwayat_penyakit }}</p>
                                    </div>
                                @endif
                            </div>

                            <!-- Contact & Address Info -->
                            <div class="space-y-6">
                                <h3 class="text-xl font-bold text-gray-900 border-b pb-2">Alamat & Kontak Darurat</h3>

                                <div>
                                    <p class="text-gray-600">Alamat Lengkap</p>
                                    <p class="font-semibold">{{ $peserta->alamat }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Provinsi</p>
                                    <p class="font-semibold">{{ $peserta->provinsi }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Kota</p>
                                    <p class="font-semibold">{{ $peserta->kota }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Kecamatan</p>
                                    <p class="font-semibold">{{ $peserta->kecamatan }}</p>
                                </div>

                                <div>
                                    <p class="text-gray-600">Kelurahan</p>
                                    <p class="font-semibold">{{ $peserta->kelurahan }}</p>
                                </div>

                                <div class="pt-6">
                                    <p class="text-gray-600">Kontak Darurat</p>
                                    <p class="font-semibold">{{ $peserta->emergency_nama }}</p>
                                    <p class="text-sm text-gray-500">{{ $peserta->emergency_nomor }}</p>
                                </div>

                                @if ($peserta->status_pembayaran === 'paid')
                                    <div class="pt-6">
                                        <p class="text-gray-600">Kode BIB</p>
                                        <p class="text-2xl font-bold text-pink-600">{{ $peserta->kode_bib }}</p>
                                    </div>

                                    <div>
                                        <p class="text-gray-600">Tanggal Pembayaran</p>
                                        <p class="font-semibold">
                                            {{ $peserta->payment_date ? $peserta->payment_date->format('d F Y H:i') : '-' }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-gray-600">Metode Pembayaran</p>
                                        <p class="font-semibold">{{ $peserta->midtrans_payment_type ?? '-' }}</p>
                                    </div>

                                    <div>
                                        <p class="text-gray-600">ID Transaksi</p>
                                        <p class="font-semibold">{{ $peserta->midtrans_transaction_id ?? '-' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- BIB Download Section for Paid Status -->
                        @if ($peserta->status_pembayaran === 'paid')
                            <div class="mt-10 pt-10 border-t">
                                <div class="max-w-2xl mx-auto text-center">
                                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Download Nomor BIB Anda</h3>
                                    <p class="text-gray-600 mb-6">
                                        Silakan download dan cetak nomor BIB Anda menggunakan kertas minimal 100gsm.<br>
                                        Pasang nomor BIB di bagian depan baju menggunakan peniti saat event.
                                    </p>
                                    <a href="{{ route('bib.show', $peserta->id) }}"
                                        class="inline-flex items-center bg-pink-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>
                                        Lihat & Cetak BIB Number
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
