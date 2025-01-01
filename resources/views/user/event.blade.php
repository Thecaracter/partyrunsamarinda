@extends('layouts.applanding')

@section('content')
    <div class="min-h-screen pt-28 bg-gradient-to-br from-pink-500 to-pink-400 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <!-- Event Title -->
                <h2 class="text-4xl md:text-5xl font-bold text-center mb-6">Active Festival Samarinda</h2>

                <!-- Event Description -->
                <p class="text-gray-700 text-lg mb-8 leading-relaxed">
                    Bersiaplah untuk merasakan keseruan lari 5KM di Active Festival Samarinda dengan rute ikonik yang
                    melintasi Mahakam Bebaya Park. Acara ini menggabungkan suasana perkotaan, ikon modern, dan keindahan
                    alam, memberikan tantangan sekaligus kesenangan bagi para peserta. Jangan lewatkan kesempatan untuk
                    melewati landmark terkenal Kota Samarinda dengan rute melingkar yang tak terlupakan!
                </p>

                <!-- Event Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Tanggal -->
                        <div class="flex items-center space-x-4 bg-pink-50 p-4 rounded-xl">
                            <div class="bg-pink-500 p-3 rounded-full">
                                <i class="fas fa-calendar text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Tanggal</h3>
                                <p class="text-pink-600">Sunday, 19th January 2025</p>
                            </div>
                        </div>

                        <!-- Jam Mulai -->
                        <div class="flex items-center space-x-4 bg-purple-50 p-4 rounded-xl">
                            <div class="bg-purple-500 p-3 rounded-full">
                                <i class="fas fa-clock text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Jam Mulai</h3>
                                <p class="text-purple-600">05.30 WITA</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Kategori -->
                        <div class="flex items-center space-x-4 bg-blue-50 p-4 rounded-xl">
                            <div class="bg-blue-500 p-3 rounded-full">
                                <i class="fas fa-running text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Kategori</h3>
                                <p class="text-blue-600">5K Men | 5K Women</p>
                            </div>
                        </div>

                        <!-- Jarak -->
                        <div class="flex items-center space-x-4 bg-green-50 p-4 rounded-xl">
                            <div class="bg-green-500 p-3 rounded-full">
                                <i class="fas fa-route text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Jarak</h3>
                                <p class="text-green-600">5 Km</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lokasi -->
                <div class="bg-yellow-50 p-4 rounded-xl mb-8">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-yellow-500 p-3 rounded-full">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">Lokasi</h3>
                            <p class="text-yellow-600">Mahakam Bebaya Park, Karang Asam Ilir, Sungai Kunjang, Samarinda
                                City, East Kalimantan</p>
                        </div>
                    </div>
                    <!-- Map Container dengan ukuran lebih besar -->
                    <div class="w-full rounded-xl overflow-hidden h-96">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.676374445949!2d117.12414547494!3d-0.5267777954199702!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df68a96daa07061%3A0x4e83e2435c60be16!2sMahakam%20Bebaya%20Park!5e0!3m2!1sen!2sid!4v1704979743690!5m2!1sen!2sid&markers=color:red%7C-0.5267777954199702,117.12414547494"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

                <!-- Social Media & Register Button -->
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="text-gray-600">
                        <p>Pantau terus Instagram kami untuk info terbaru:</p>
                        <a href="https://instagram.com/ActiveFestivalSamarinda"
                            class="text-pink-600 font-semibold hover:text-pink-700">
                            @ActiveFestivalSamarinda
                        </a>
                    </div>
                    <a href="{{ route('registrasi.index') }}"
                        class="bg-pink-600 text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-pink-700 transition-all duration-200 transform hover:scale-105">
                        Daftar Sekarang
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
