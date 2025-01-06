@extends('layouts.applanding')

@section('content')
    <div
        class="min-h-screen bg-gradient-to-b from-blue-500 to-blue-600 py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12 text-center">
                <!-- Maintenance Icon -->
                <div class="mb-8 flex justify-center">
                    <div class="bg-blue-100 p-4 rounded-full">
                        <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Maintenance Text -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                    Website Sedang Dalam Perbaikan
                </h1>

                <p class="text-xl text-gray-600 mb-8">
                    Mohon maaf atas ketidaknyamanannya. Website PARTY RUN sedang dalam perbaikan untuk memberikan pengalaman
                    yang lebih baik untuk Anda.
                </p>

                <!-- Estimated Time -->
                <div class="bg-blue-50 rounded-xl p-6 mb-8">
                    <h3 class="text-lg font-semibold text-blue-800 mb-2">
                        Perkiraan Waktu
                    </h3>
                    <p class="text-blue-600">
                        Website akan kembali online dalam waktu <span class="font-bold">24 jam</span>
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Email -->
                    <div class="bg-gray-50 p-6 rounded-xl">
                        <div class="flex items-center justify-center space-x-3 mb-3">
                            <i class="fas fa-envelope text-blue-500 text-xl"></i>
                            <span class="font-semibold text-gray-800">Email</span>
                        </div>
                        <a href="mailto:partycolorbderma@gmail.com" class="text-blue-600 hover:text-blue-700 font-medium">
                            partycolorbderma@gmail.com
                        </a>
                    </div>

                    <!-- Instagram -->
                    <div class="bg-gray-50 p-6 rounded-xl">
                        <div class="flex items-center justify-center space-x-3 mb-3">
                            <i class="fab fa-instagram text-pink-500 text-xl"></i>
                            <span class="font-semibold text-gray-800">Instagram</span>
                        </div>
                        <a href="https://instagram.com/party.run.smr" target="_blank"
                            class="text-pink-600 hover:text-pink-700 font-medium">
                            @party.run.smr
                        </a>
                    </div>
                </div>

                <!-- Footer Note -->
                <p class="mt-8 text-gray-500">
                    Terima kasih atas pengertian dan kesabaran Anda
                </p>
            </div>
        </div>
    </div>
@endsection
