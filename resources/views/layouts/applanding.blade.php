<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Party Color Run - @yield('title')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/8.png') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Additional Styles -->
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="fixed top-0 z-10 w-full py-4 md:py-6 text-black bg-white shadow-md" x-data="{ mobileMenuOpen: false }">
            <div class="container mx-auto px-4 md:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <!-- Logo Area -->
                    <div class="flex items-center space-x-4">
                        <a href="/" class="flex items-center space-x-2">
                            <img src="{{ asset('Images/1.png') }}" alt="Logo" class="h-8 md:h-10" />
                        </a>
                        <!-- Social Links -->
                        <ul class="hidden md:flex items-center space-x-4">
                            <li>
                                <a href="https://www.instagram.com/party.run.smr" target="_blank"
                                    class="text-2xl hover:text-blue-600 transition-colors">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Desktop Menu -->
                    <ul class="hidden lg:flex items-center space-x-6">
                        <li><a class="hover:text-blue-600 transition-colors" href="/">Home</a></li>
                        <li><a class="hover:text-blue-600 transition-colors" href="{{ route('event') }}">Event</a></li>
                        <li><a class="hover:text-blue-600 transition-colors" href="{{ route('about') }}">About us</a>
                        </li>
                        <li><a class="hover:text-blue-600 transition-colors" href="{{ route('rules') }}">Rules</a></li>
                        <li>
                            <a class="border border-black hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-colors py-2 px-4 rounded-md"
                                href="/check-order">Check Order</a>
                        </li>
                        <li>
                            <a class="bg-black text-white hover:bg-blue-800 transition-colors py-2 px-4 rounded-md"
                                href="{{ route('registrasi.index') }}">Register</a>
                        </li>
                    </ul>

                    <!-- Mobile Menu Button -->
                    <button class="lg:hidden p-2 rounded-md hover:bg-gray-100 transition-colors"
                        @click="mobileMenuOpen = !mobileMenuOpen" aria-label="Toggle menu">
                        <i class="fas" :class="{ 'fa-xmark': mobileMenuOpen, 'fa-bars': !mobileMenuOpen }">
                        </i>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div class="lg:hidden" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4">
                    <ul class="py-4 space-y-4">
                        <li><a class="block hover:text-blue-600 transition-colors py-2" href="/">Home</a></li>
                        <li><a class="block hover:text-blue-600 transition-colors py-2" href="/event">Event</a></li>
                        <li><a class="block hover:text-blue-600 transition-colors py-2" href="/about">About Us</a></li>
                        <li><a class="block hover:text-blue-600 transition-colors py-2" href="/rules">Rules</a></li>
                        <li class="pt-2">
                            <a class="block border border-black hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-colors py-2 px-4 rounded-md text-center"
                                href="/check-order">Check Order</a>
                        </li>
                        <li class="pt-2">
                            <a class="block bg-black text-white hover:bg-blue-800 transition-colors py-2 px-4 rounded-md text-center"
                                href="{{ route('registrasi.index') }}">Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="pt-20 md:pt-24">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                        <p class="font-bold">Sukses!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('warning'))
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg">
                        <p class="font-bold">Perhatian!</p>
                        <p>{{ session('warning') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <p class="font-bold">Error!</p>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            @if (session('message'))
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg">
                        <p class="font-bold">Informasi</p>
                        <p>{{ session('message') }}</p>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-black text-white py-8 mt-12">
            <div class="container mx-auto px-4 md:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-xl font-bold mb-4">Party Color Run</h3>
                        <p class="text-gray-400">Join us for the most colorful run in Samarinda!</p>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a href="/event" class="text-gray-400 hover:text-white transition-colors">Event
                                    Details</a></li>
                            <li><a href="/rules" class="text-gray-400 hover:text-white transition-colors">Rules</a>
                            </li>
                            <li><a href="/register" class="text-gray-400 hover:text-white transition-colors">Register
                                    Now</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-4">Contact Us</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center space-x-2">
                                <i class="fab fa-instagram"></i>
                                <a href="https://www.instagram.com/party.run.smr"
                                    class="text-gray-400 hover:text-white transition-colors">@party.run.smr</a>
                            </li>
                            <!--<li class="flex items-center space-x-2">-->
                            <!--    <i class="fab fa-whatsapp"></i>-->
                            <!--    <span class="text-gray-400"></span>-->
                            <!--</li>-->
                        </ul>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-800 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Event Experienced by SKY7.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
