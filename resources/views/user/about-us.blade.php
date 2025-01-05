@extends('layouts.applanding')

@section('content')
    <div class="min-h-screen pt-28 bg-blue-500 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                <!-- About Us Section -->
                <div class="mb-12">
                    <h2 class="text-4xl md:text-5xl font-bold text-center mb-6">About Us</h2>
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Selamat datang di PARTY RUN - Lari yang Penuh Warna dan Keceriaan! Siapkan dirimu untuk merasakan
                        sensasi berlari yang tak terlupakan! PARTY RUN adalah acara lari penuh warna yang menggabungkan
                        semangat olahraga dengan kegembiraan. Bayangkan, setiap langkah yang kamu ambil akan membawa
                        warna-warni ceria yang membalut tubuhmu, memberikan kesan tak hanya sehat, tetapi juga penuh energi
                        positif!
                    </p>
                </div>

                <!-- Contact Section -->
                <div class="border-t border-gray-200 pt-12">
                    <h2 class="text-4xl md:text-5xl font-bold text-center mb-6">Kontak Kami</h2>
                    <p class="text-gray-700 text-lg text-center mb-8">
                        Ingin bekerja sama dengan kami? Kirim pesan lewat e-mail atau hubungi nomor telepon kami!
                    </p>

                    <!-- Contact Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Email Card -->
                        <div class="bg-blue-50 p-6 rounded-xl">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="bg-blue-500 p-3 rounded-full">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-xl">Email</h3>
                                </div>
                            </div>
                            <a href="mailto:partycolorbderma@gmail.com"
                                class="text-blue-600 hover:text-blue-700 font-semibold text-lg">
                                partycolorbderma@gmail.com
                            </a>
                        </div>

                        <!-- Instagram Card -->
                        <div class="bg-pink-50 p-6 rounded-xl">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="bg-pink-500 p-3 rounded-full">
                                    <i class="fab fa-instagram text-white text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-xl">Instagram</h3>
                                </div>
                            </div>
                            <a href="https://instagram.com/party.run.smr" target="_blank"
                                class="text-pink-600 hover:text-pink-700 font-semibold text-lg">
                                @party.run.smr
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
