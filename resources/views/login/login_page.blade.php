<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Log into CouponBandit' }}</title>
    <style>
        .login-bg {
            background-color: #efe7da;
        }

        .mcm-panel {
            background-color: #f8f4ec;
        }

        .mcm-card {
            background-color: #fffdf9;
        }

        .shape-terracotta {
            background-color: #cf6f4c;
        }

        .shape-mustard {
            background-color: #d79b2f;
        }

        .shape-ink {
            background-color: #21313a;
        }
    </style>
</head>

<body class="h-full login-bg text-zinc-900 antialiased">
    <main class="min-h-screen px-4 py-6 sm:px-6 sm:py-10">
        <div class="mx-auto grid w-full max-w-4xl overflow-hidden rounded-3xl border border-zinc-300 bg-white shadow-xl md:grid-cols-2">
            <section class="mcm-panel relative min-h-[220px] overflow-hidden p-8 sm:p-10 lg:min-h-[620px]">
                <div class="relative z-10">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-xl font-semibold tracking-tight">
                        Coupon<span class="text-indigo-600">Bandit</span>
                    </a>
                    <p class="mt-12 max-w-md text-3xl font-semibold leading-tight sm:text-4xl">
                        Deals with style.
                        <span class="block text-zinc-600">Log in and pick up where you left off.</span>
                    </p>
                    <p class="mt-6 max-w-sm text-base text-zinc-700">
                        Daily drops. Verified codes. A better way to save.
                    </p>
                </div>
            </section>

            <section class="mcm-card flex items-center p-6 sm:p-8 lg:p-10">
                <div class="w-full max-w-md">
                    <h1 class="text-3xl font-semibold tracking-tight">Welcome back</h1>
                    <p class="mt-2 text-zinc-600">Sign in to access your saved stores and rewards.</p>
                    <p class="mt-2 text-zinc-600">This is a dummy site strictly for demoing purposes.</p>

                    @if ($errors->any())
                        <div class="mt-6 rounded-xl border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('login.attempt') }}" method="POST" class="mt-8 space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-zinc-700">Email address</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                class="block w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-zinc-900"
                                placeholder="you@example.com"
                                value="{{ old('email') }}">
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="block text-sm font-medium text-zinc-700">Password</label>
                                <a href="#" class="text-sm font-medium text-zinc-700 hover:text-zinc-900">Forgot?</a>
                            </div>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                class="block w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-zinc-900 outline-none transition focus:border-zinc-900"
                                placeholder="Enter your password">
                        </div>

                        <div class="flex items-center gap-2">
                            <input id="remember" name="remember" type="checkbox"
                                {{ old('remember') ? 'checked' : '' }}
                                class="h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-900">
                            <label for="remember" class="text-sm text-zinc-700">Remember me</label>
                        </div>

                        <button type="submit"
                            class="w-full rounded-xl bg-zinc-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-zinc-800">
                            Sign in
                        </button>
                    </form>

                    <p class="mt-6 text-sm text-zinc-600">
                        New here?
                        <a href="#" class="font-semibold text-zinc-900 underline-offset-2 hover:underline">Create an account</a>
                    </p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
