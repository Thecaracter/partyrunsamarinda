@extends('layouts.applanding')

@section('title', 'Home')

@section('content')



    <!-- Hero Section -->
    <section class="hero-section" style="background-color: white;">

        <div class="container relative h-full text-gray-900">
            <!-- Menambahkan gambar di dalam Hero Section -->
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                <img src="Images/hero1.png" alt="Gambar Utama" style="width: 100vw; height: 100vh; object-fit: cover;">
            </div>


            <div class="relative flex flex-col justify-center h-full px-4 sm:px-8 lg:px-16">
                <h2 class="mb-4 text-3xl sm:text-5xl lg:text-7xl 2xl:text-8xl font-bold leading-tight text-black">
                    PARTY COLOR RUN <br class="hidden sm:block"> SAMARINDA
                </h2>


                <div class="flex flex-col sm:flex-row gap-4 mt-6">
                    <!--<a href="{{ route('registrasi.index') }}" class="w-full sm:w-auto">-->
                    <button
                        class="w-full sm:w-auto border-2 bg-blue-600 border-white text-white hover:bg-blue-700 hover:scale-105 transition-all duration-300 py-3 px-6 rounded-md font-bold shadow-lg">
                        Registration Closed Sementara
                    </button>
                    </a>
                    <a href="/check-order" class="w-full sm:w-auto">
                        <button
                            class="w-full sm:w-auto border-2 border-blue-500 bg-transparent text-blue-600 hover:bg-white/10 hover:scale-105 transition-all duration-300 py-3 px-6 rounded-md font-bold backdrop-blur-sm">
                            Check Order
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>


    <style>
        /* Mengatur background agar responsif */
        .hero-section {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            padding-top: 150px;
            width: 100%;
            position: relative;
            color: white;
            overflow: hidden;
        }

        /* Mengatur gambar di dalam hero section agar responsif */
        .hero-section img {
            max-width: 100%;
            height: auto;
        }

        /* Menangani posisi gambar agar selalu berada di tengah */
        .hero-section .absolute {
            position: absolute;
            top: 110%;
            left: 40%;
            transform: translate(-40%, -50%);
            width: 100%;
        }


        /* Menangani responsivitas di perangkat mobile */
        @media (max-width: 768px) {
            .hero-section {
                background-position: top;
                padding-top: 90px;
            }

            .hero-section .absolute {
                width: 100%;
                /* Gambar lebih kecil pada perangkat mobile */
                top: 120%;
                left: 40%;
            }
        }

        /* Mengatur gambar di dalam hero section untuk desktop */
        @media (min-width: 1024px) {
            .hero-section .absolute img {
                max-width: 300%;
                /* Membatasi lebar gambar menjadi maksimal 50% pada desktop */
                height: auto;
            }
        }
    </style>



    <!-- Presented By Section -->
    <section class="py-10 sm:py-14 lg:py-20" style="background-color: #ffffff;">
        <div class="px-4 sm:px-8 lg:px-28">
            <div class="mb-8 sm:mb-12 text-center">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-black">Presented By</h2>
            </div>
            <div class="flex justify-center items-center">
                <img src="{{ asset('Images/logorevisi.png') }}" alt="" class="px-4 sm:px-6 logo-size w-auto">
            </div>

            <!--<img src="{{ asset('Images/logo_dyza.png') }}" alt=""-->
            <!--    class="px-4 sm:px-6 max-h-8 sm:max-h-12 lg:max-h-16 w-auto" style="">-->
        </div>

    </section>

    <style>
        /* Mengatur ukuran logo untuk berbagai ukuran layar */
        .logo-size {
            max-height: 6rem;
            /* Default tinggi maksimum */
            transition: all 0.3s ease;
            /* Transisi halus untuk perubahan ukuran */
        }

        @media (max-width: 768px) {
            .logo-size {
                max-height: 6rem;
                /* Lebih kecil pada perangkat mobile */
            }
        }

        @media (min-width: 768px) and (max-width: 1024px) {
            .logo-size {
                max-height: 5rem;
                /* Sedikit lebih besar pada tablet */
            }
        }

        @media (min-width: 1024px) {
            .logo-size {
                max-height: 8rem;
                /* Ukuran default yang lebih besar untuk desktop */
            }
        }
    </style>





    <!-- Welcome Section -->
    <section class="py-10 sm:py-14 lg:py-24 text-white relative"
        style="background-image: url('{{ asset('Images/el-02.png') }}'); background-size: cover; background-position: center;">
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
            <div class="grid grid-cols-1 sm:grid-cols-4 lg:grid-cols-4 gap-8 justify-items-center">
                <div class="w-full max-w-xs">
                    <img src="{{ asset('Images/el-03.png') }}" alt="Pelajar" class="w-full h-auto" />
                </div>
                <div class="w-full max-w-xs">
                    <img src="{{ asset('Images/el-04.png') }}" alt="Umum" class="w-full h-auto" />
                </div>
                <div class="w-full max-w-xs">
                    <img src="{{ asset('Images/el-05.png') }}" alt="Umum" class="w-full h-auto" />
                </div>
                <div class="w-full max-w-xs">
                    <img src="{{ asset('Images/el-06.png') }}" alt="Umum" class="w-full h-auto" />
                </div>

            </div>
        </div>
    </section>

    <!-- Countdown Section -->
    <section class="py-10 sm:py-14 lg:py-24 bg-blue-500 text-[#FFD942]">
        <div class="container px-4 sm:px-8 lg:px-28 mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column sama seperti sebelumnya -->
                <div class="lg:col-span-5">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight mb-6">Count down to race Day</h2>
                    <p class="text-base sm:text-lg">
                        Time is ticking, and spots are filling up fast! Secure your place, mark your calendar,
                        and get ready to experience the PARTY COLOR RUN SAMARINDA.
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
                    targetDate: new Date('2025-02-23T00:00:00').getTime(),

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
