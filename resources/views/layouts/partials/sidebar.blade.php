<!-- Off-canvas menu for mobile -->
<div class="lg:hidden" x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="relative z-50" role="dialog" aria-modal="true">

    <!-- Gradient Background backdrop -->
    <div class="fixed inset-0 bg-gradient-to-br from-fuchsia-500/80 via-purple-500/80 to-pink-500/80 backdrop-blur-sm">
    </div>

    <div class="fixed inset-0 flex">
        <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full" class="relative flex w-full max-w-xs flex-1">

            <!-- Close button -->
            <div class="absolute top-0 right-0 -mr-12 pt-4">
                <button type="button" @click="sidebarOpen = false"
                    class="ml-1 flex h-10 w-10 items-center justify-center rounded-full border-2 border-white/20 hover:border-white/40 transition-colors duration-200">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Content - Mobile -->
            <div
                class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-b from-purple-600 to-fuchsia-600 px-6 pb-4">
                <div class="flex h-16 shrink-0 items-center">
                    <div class="flex items-center gap-2">
                        <div
                            class="p-2 bg-white/10 rounded-lg rotate-6 transform hover:rotate-0 transition-transform duration-300">
                            <span class="text-2xl font-bold text-white">PR</span>
                        </div>
                        <span class="text-2xl font-bold text-white">Party Run</span>
                    </div>
                </div>

                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="space-y-3">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="{{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} 
                                            group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.sizes.index') }}"
                                        class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5" />
                                        </svg>
                                        Size
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                        </svg>
                                        Peserta
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                        </svg>
                                        Pembayaran
                                    </a>
                                </li>

                                <li>
                                    <a href="#"
                                        class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Settings
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- User Menu -->
                        <li class="-mx-6 mt-auto">
                            <a href="#"
                                class="flex items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white hover:bg-white/10 transition duration-200">
                                <img class="h-8 w-8 rounded-full bg-white/10"
                                    src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="">
                                <span class="sr-only">Your profile</span>
                                <span aria-hidden="true">{{ auth()->user()->name }}</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Static sidebar for desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72">
    <!-- Desktop Sidebar -->
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-gradient-to-b from-purple-600 to-fuchsia-600 px-6">
        <div class="flex h-16 shrink-0 items-center">
            <div class="flex items-center gap-2">
                <div
                    class="p-2 bg-white/10 rounded-lg rotate-6 transform hover:rotate-0 transition-transform duration-300">
                    <span class="text-2xl font-bold text-white">PR</span>
                </div>
                <span class="text-2xl font-bold text-white">Party Run</span>
            </div>
        </div>

        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <!-- Same links as mobile, but adapted for desktop -->
                <li>
                    <ul role="list" class="space-y-3">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="{{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'text-white/70 hover:bg-white/10 hover:text-white' }} 
                                    group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.sizes.index') }}"
                                class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 13.5V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 010 3m0-3a1.5 1.5 0 000 3m0 9.75V10.5" />
                                </svg>
                                Size
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                                Peserta
                            </a>
                        </li>

                        <li>
                            <a href="#"
                                class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                                Pembayaran
                            </a>
                        </li>

                        <li>
                            <a href="#"
                                class="text-white/70 hover:bg-white/10 hover:text-white group flex items-center gap-x-3 rounded-lg p-3 text-sm font-semibold leading-6 transition duration-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User Menu - Desktop -->
                <li class="-mx-6 mt-auto">
                    <div class="flex items-center gap-x-4 px-6 py-4 bg-white/10 backdrop-blur-sm rounded-t-xl">
                        <img class="h-10 w-10 rounded-full bg-white/10"
                            src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-white/70 truncate">{{ auth()->user()->email }}</p>
                        </div>
                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                class="p-2 text-white/70 hover:text-white rounded-lg hover:bg-white/10 transition-colors duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>