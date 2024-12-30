<header
    class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 bg-white/80 backdrop-blur-sm border-b border-purple-100 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
    <div class="flex flex-1 items-center gap-x-4">
        <!-- Mobile menu button -->
        <button type="button" class="lg:hidden p-2 text-gray-700" @click="sidebarOpen = true">
            <span class="sr-only">Open sidebar</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        <!-- Title -->
        <h1 class="text-lg font-semibold text-gray-900">@yield('title')</h1>
    </div>

    <!-- Right section -->
    <div class="flex shrink-0 items-center gap-x-4 ml-auto">
        <!-- Profile dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" type="button"
                class="flex items-center gap-x-4 rounded-full bg-gradient-to-r from-purple-50 to-fuchsia-50 p-1.5">
                <span class="hidden lg:flex lg:items-center order-1">
                    <span class="text-sm font-semibold text-purple-900">{{ auth()->user()->name }}</span>
                    <svg class="ml-2 h-5 w-5 text-purple-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
                <img class="h-8 w-8 rounded-full bg-purple-100 order-2"
                    src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=DDD6FE&color=7C3AED"
                    alt="">
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-purple-100 focus:outline-none">
                <div class="px-4 py-2 border-b border-purple-50">
                    <p class="text-sm font-medium text-purple-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-purple-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="py-1">
                    @csrf
                    <button type="submit" class="w-full px-3 py-1 text-sm text-left text-gray-900 hover:bg-purple-50">
                        Sign out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
