@extends('layouts.applanding')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="min-h-screen lg:min-h-[760px] pt-20 lg:pt-28 pb-20 text-white relative overflow-hidden"
        style="background-image: url('{{ asset('Images/10.png') }}'); background-size: cover; background-position: center;">
        <div class="container relative h-full px-4 mx-auto text-gray-900">
            <img src="{{ asset('Images/Fest-Logo.png') }}" alt=""
                class="absolute hidden lg:block -left-20 xl:-left-64 top-64 opacity-30 h-48 xl:h-72" />

            <div class="relative flex flex-col justify-center h-full px-4 sm:px-8 lg:px-16">
                <h2 class="mb-4 text-3xl sm:text-5xl lg:text-7xl 2xl:text-8xl font-bold leading-tight text-white">
                    PARTY COLOR RUN <br class="hidden sm:block"> SAMARINDA
                </h2>

                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    <a href="{{ route('registrasi.index') }}" class="w-full sm:w-auto">
                        <button
                            class="w-full sm:w-auto border-2 bg-blue-600 border-white text-white hover:bg-blue-700 hover:scale-105 transition-all duration-300 py-3 px-6 rounded-md font-bold shadow-lg">
                            Registration
                        </button>
                    </a>
                    <a href="/check-order" class="w-full sm:w-auto">
                        <button
                            class="w-full sm:w-auto border-2 border-white bg-transparent text-white hover:bg-white/10 hover:scale-105 transition-all duration-300 py-3 px-6 rounded-md font-bold backdrop-blur-sm">
                            Check Order
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Presented By Section -->
    <section class="py-10 sm:py-14 lg:py-20" style="background: linear-gradient(45deg, #FF1493, #FF69B4);">
        <div class="px-4 sm:px-8 lg:px-28">
            <div class="mb-8 sm:mb-12 text-center">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white">Presented By</h2>
            </div>
            <div class="flex justify-center items-center">
                <img src="{{ asset('Images/logo_dyza.png') }}" alt=""
                    class="px-4 sm:px-6 max-h-8 sm:max-h-12 lg:max-h-16 w-auto" style="">
                <img src="{{ asset('Images/logo_dyza.png') }}" alt=""
                    class="px-4 sm:px-6 max-h-8 sm:max-h-12 lg:max-h-16 w-auto" style="">
            </div>
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="py-10 sm:py-14 lg:py-24 text-white relative"
        style="background-image: url('{{ asset('Images/3.png') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="container px-4 sm:px-8 lg:px-28 mx-auto relative z-10">
            <div class="flex flex-col items-center">
                <img src="{{ asset('Images/8.png') }}" alt="Logo Festival" class="mx-auto w-full max-w-[200px] h-auto">
                <div class="mt-6 text-center w-full lg:w-2/3">
                    <p class="text-base sm:text-lg font-bold">
                        Selamat datang di PARTY RUN - Lari yang Penuh Warna dan Keceriaan!
                        Siapkan dirimu untuk merasakan sensasi berlari yang tak terlupakan!
                        PARTY RUN adalah acara lari penuh warna yang menggabungkan semangat olahraga dengan kegembiraan.
                        Bayangkan, setiap langkah yang kamu ambil akan membawa warna-warni ceria yang membalut tubuhmu,
                        memberikan kesan tak hanya sehat, tetapi juga penuh energi positif!
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-10 sm:py-14 lg:py-24 bg-white text-zinc-900">
        <div class="container px-4 mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 justify-items-center">
                <div class="w-full max-w-xs">
                    <img src="{{ asset('Images/pelajar.png') }}" alt="Pelajar" class="w-full h-auto" />
                </div>
                <div class="w-full max-w-xs">
                    <img src="{{ asset('Images/umum.png') }}" alt="Umum" class="w-full h-auto" />
                </div>
                <div class="w-full max-w-xs sm:col-span-2 lg:col-span-1">
                    <img src="{{ asset('Images/master.png') }}" alt="Master" class="w-full h-auto" />
                </div>
            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <!-- Countdown Section -->
    <section class="py-10 sm:py-14 lg:py-24 bg-blue-500 text-[#FFD942]">
        <div class="container px-4 sm:px-8 lg:px-28 mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column sama seperti sebelumnya -->
                <div class="lg:col-span-5">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight mb-6">Count down to race Day</h2>
                    <p class="text-base sm:text-lg">
                        Time is ticking, and spots are filling up fast! Secure your place, mark your calendar,
                        and get ready to experience the Active Festival Samarinda like never before.
                    </p>
                    <div class="flex flex-wrap gap-4 py-6">
                        <a href="/event">
                            <button
                                class="px-6 py-3 text-base sm:text-lg font-medium bg-white hover:bg-opacity-90 text-gray-900 rounded">
                                Learn More
                            </button>
                        </a>
                    </div>
                    <p class="text-sm">
                        By clicking Register you're confirming that you agree with our Terms and Conditions.
                    </p>
                </div>

                <!-- Right Column with Countdown -->
                <div class="lg:col-span-6 lg:col-start-7" x-data="countdown">
                    <div class="mb-4">
                        <h5 class="text-xl sm:text-2xl font-bold text-center mb-6">
                            Countdown to Race Day!
                        </h5>
                        <div class="max-w-sm mx-auto border border-[#FFD942] p-4">
                            <div class="grid grid-cols-4 gap-4">
                                <!-- Days -->
                                <div class="text-center">
                                    <div class="py-2">
                                        <h3 class="text-2xl sm:text-4xl font-bold"
                                            x-text="days.toString().padStart(2, '0')">00</h3>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold">Days</p>
                                </div>

                                <!-- Hours -->
                                <div class="text-center">
                                    <div class="py-2">
                                        <h3 class="text-2xl sm:text-4xl font-bold"
                                            x-text="hours.toString().padStart(2, '0')">00</h3>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold">Hours</p>
                                </div>

                                <!-- Minutes -->
                                <div class="text-center">
                                    <div class="py-2">
                                        <h3 class="text-2xl sm:text-4xl font-bold"
                                            x-text="minutes.toString().padStart(2, '0')">00</h3>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold">Minutes</p>
                                </div>

                                <!-- Seconds -->
                                <div class="text-center">
                                    <div class="py-2">
                                        <h3 class="text-2xl sm:text-4xl font-bold"
                                            x-text="seconds.toString().padStart(2, '0')">00</h3>
                                    </div>
                                    <p class="text-sm sm:text-base font-semibold">Seconds</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('countdown', () => ({
                    days: 0,
                    hours: 0,
                    minutes: 0,
                    seconds: 0,
                    targetDate: new Date('2025-02-02T00:00:00').getTime(),

                    init() {
                        this.updateCountdown();
                        setInterval(() => {
                            this.updateCountdown();
                        }, 1000);
                    },

                    updateCountdown() {
                        const now = new Date().getTime();
                        const distance = this.targetDate - now;

                        if (distance > 0) {
                            this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                            this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        } else {
                            this.days = 0;
                            this.hours = 0;
                            this.minutes = 0;
                            this.seconds = 0;
                        }
                    }
                }));
            });
        </script>
    @endpush
@endsection
