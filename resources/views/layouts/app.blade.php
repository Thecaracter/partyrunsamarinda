<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Party Run Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    @stack('styles')
    <div x-data="{ sidebarOpen: false }" class="h-full">
        <!-- Sidebar for mobile -->
        <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen" class="fixed inset-0 bg-gray-900/80"
                x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            </div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen" class="relative mr-16 flex w-full max-w-xs flex-1"
                    x-transition:enter="transition ease-in-out duration-300 transform"
                    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in-out duration-300 transform"
                    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
                    @include('layouts.partials.sidebar')
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            @include('layouts.partials.sidebar')
        </div>

        <!-- Content area -->
        <div class="lg:pl-72">
            @include('layouts.partials.header')

            <!-- Main content -->
            <main class="py-8">
                <div class="px-4 sm:px-6 lg:px-8">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-200 bg-white">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="py-4">
                        @include('layouts.partials.footer')
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
