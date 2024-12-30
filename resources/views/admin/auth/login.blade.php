<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Run Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-br from-fuchsia-400 via-purple-500 to-indigo-500"
    style="font-family: 'Poppins', sans-serif;">
    <!-- Animated Particles -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-10 w-20 h-20 rounded-full bg-white/10 animate-blob"></div>
        <div class="absolute top-40 left-10 w-32 h-32 rounded-full bg-white/10 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-40 right-20 w-28 h-28 rounded-full bg-white/10 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">
            <!-- Decorative Corner -->
            <div
                class="absolute -top-10 -right-10 w-40 h-40 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full opacity-10">
            </div>

            <!-- Header -->
            <div class="relative text-center mb-8">
                <div
                    class="w-24 h-24 mx-auto mb-4 bg-gradient-to-tr from-pink-500 to-fuchsia-600 rounded-2xl rotate-12 flex items-center justify-center shadow-lg transform hover:rotate-0 transition-transform duration-300">
                    <span
                        class="text-white text-3xl font-bold -rotate-12 transform hover:rotate-0 transition-transform duration-300">PR</span>
                </div>
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-fuchsia-600 to-pink-600 bg-clip-text text-transparent mb-2">
                    Party Run
                </h1>
                <p class="text-gray-500 text-sm">Admin Dashboard Access</p>
            </div>

            <!-- Alert Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <p class="text-red-600 text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="space-y-4">
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-fuchsia-500 focus:ring focus:ring-fuchsia-200 transition-all duration-200 outline-none"
                            placeholder="Email address">
                    </div>
                    <div>
                        <input type="password" name="password" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-fuchsia-500 focus:ring focus:ring-fuchsia-200 transition-all duration-200 outline-none"
                            placeholder="Password">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-fuchsia-600 border-gray-300 rounded focus:ring-fuchsia-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
                </div>

                <button type="submit"
                    class="w-full py-3 px-6 bg-gradient-to-r from-fuchsia-600 to-pink-600 text-white font-medium rounded-xl
                           hover:from-fuchsia-700 hover:to-pink-700 transform hover:-translate-y-0.5 transition-all duration-200
                           focus:outline-none focus:ring-2 focus:ring-fuchsia-500 focus:ring-offset-2 shadow-lg">
                    Sign In
                </button>
            </form>
        </div>
    </div>

    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>

</html>
