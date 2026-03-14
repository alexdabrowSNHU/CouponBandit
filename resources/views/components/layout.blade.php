<!DOCTYPE html>
<html lang="en" class="h-full bg-zinc-50">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'CouponBandit' }}</title>
</head>


<body class="min-h-screen flex flex-col flex-1 text-zinc-900 antialiased">

    <!-- Top Navigation -->
    <header class="bg-white border-b border-zinc-200 relative">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

            <!-- Brand -->
            <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight">
                Coupon<span class="text-indigo-600">Bandit</span>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-zinc-600">
                <a href="{{ route('deals.index') }}" class="hover:text-zinc-900 transition">Deals</a>
                <a href="{{ route('categories.index') }}" class="hover:text-zinc-900 transition">Categories</a>
                <a href="{{ route('merchants.index') }}" class="hover:text-zinc-900 transition">Stores</a>
                <a href="{{ route('my_rewards.index') }}" class="hover:text-zinc-900 transition">My Rewards</a>
            </nav>

            <!-- Desktop Right -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <span class="text-sm text-zinc-600">
                        {{ auth()->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium bg-zinc-900 text-white px-4 py-2 rounded-lg hover:bg-zinc-800 transition">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 transition">
                        Login
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger -->
            <button id="mobileMenuBtn" class="md:hidden flex items-center">
                <svg class="w-6 h-6 text-zinc-700" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="md:hidden hidden border-t border-zinc-200 bg-white">

            <div class="px-6 py-6 space-y-4 text-sm font-medium text-zinc-700">

                <a href="{{ route('deals.index') }}" class="block hover:text-zinc-900">Deals</a>
                <a href="{{ route('categories.index') }}" class="block hover:text-zinc-900">Categories</a>
                <a href="{{ route('merchants.index') }}" class="block hover:text-zinc-900">Stores</a>
                <a href="{{ route('my_rewards.index') }}" class="block hover:text-zinc-900">My Rewards</a>

                <div class="pt-4 border-t border-zinc-200 space-y-5">
                    @auth
                        <span class="block text-zinc-600">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full rounded-lg bg-zinc-900 px-4 py-2 text-center text-white hover:bg-zinc-800 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block hover:text-zinc-900">Login</a>
                    @endauth
                </div>

            </div>
        </div>
    </header>


    <!-- Page Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>


    <!-- Footer -->
    <footer class="bg-white border-t border-zinc-200 mt-24">
        <div class="max-w-6xl mx-auto px-6 py-4 text-sm text-zinc-500 flex flex-col md:flex-row justify-between gap-6">

            <div class="items-center">
                <div class="font-semibold text-zinc-800 mb-2">
                    CouponBandit
                </div>
                <p>
                    Verified deals. Zero nonsense.
                </p>
            </div>

            <div class="flex gap-8 items-center">
                <a href="#" class="hover:text-zinc-800 transition">About</a>
                <a href="#" class="hover:text-zinc-800 transition">Privacy</a>
                <a href="#" class="hover:text-zinc-800 transition">Terms</a>
                <a href="#" class="hover:text-zinc-800 transition">Contact</a>
            </div>

        </div>
    </footer>

</body>

</html>
