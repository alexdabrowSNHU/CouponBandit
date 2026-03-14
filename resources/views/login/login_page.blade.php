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
            <section class="mcm-panel relative flex min-h-[220px] flex-col overflow-hidden p-8 sm:p-10 self-stretch">
                <div class="relative z-10 flex flex-1 flex-col">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-xl font-semibold tracking-tight">
                        Coupon<span class="text-indigo-600">Bandit</span>
                    </a>
                    <p class="mt-12 max-w-md text-3xl font-semibold leading-tight sm:text-4xl">
                        Deals with style.
                        <span class="block text-zinc-600">Log in and pick up where you left off.</span>
                    </p>
                    <div class="flex-1"></div>
                    <div class="flex flex-col justify-end">
                        <p class="max-w-sm text-base text-zinc-700">
                            Built with Laravel.
                        </p>
                        <button
                            type="button"
                            id="devLogToggle"
                            aria-controls="devLogPanel"
                            aria-expanded="false"
                            class="mt-2 inline-flex items-center gap-1 whitespace-nowrap text-xs font-medium text-zinc-500 transition hover:text-zinc-700 focus:outline-none focus-visible:text-zinc-800 focus-visible:underline">
                            <span id="devLogToggleLabel" class="whitespace-nowrap">Show dev log</span>
                            <svg id="devLogChevron" class="h-3 w-3 transition-transform" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.51a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </section>

            <section class="mcm-card flex flex-col justify-center p-6 sm:p-8 lg:p-10">
                <div class="w-full max-w-md">
                    <h1 class="text-3xl font-semibold tracking-tight">Welcome back</h1>
                    <p class="mt-2 text-zinc-600">Sign in to access your saved stores and rewards.</p>

                    @if (session('error'))
                        <div class="mt-6 rounded-xl border border-amber-300 bg-amber-50 p-3 text-sm text-amber-800">
                            {{ session('error') }}
                        </div>
                    @endif

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

                    <form action="{{ route('login.demo') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-xl border border-zinc-300 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                            Continue as Demo User
                        </button>
                    </form>

                    <p class="mt-6 text-sm text-zinc-600">
                        New here?
                        <a href="#" class="font-semibold text-zinc-900 underline-offset-2 hover:underline">Create an account</a>
                    </p>
                </div>
            </section>
        </div>

         <div class="mx-auto grid w-full max-w-xl overflow-hidden rounded-3xl text-zinc-700 text-center px-4 mt-4">
            This is a dummy site strictly for demoing purposes.
         </div>
          <div class="mx-auto grid w-full max-w-xl overflow-hidden rounded-3xl text-zinc-700 text-center px-4 mt-1">
            Some features are not functional.
         </div>
        <section id="devLogPanel" class="mx-auto mt-4 hidden w-full max-w-4xl overflow-hidden rounded-2xl border border-zinc-300 bg-white/80 shadow-sm" hidden>
            <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3 sm:px-6">
                <h2 class="text-sm font-semibold tracking-wide text-zinc-900">Development Log</h2>
            </div>
            <div class="px-4 py-4 sm:px-6">
                <ul class="space-y-3 text-sm text-zinc-700">
                    <li class="flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                        <span class="min-w-0 flex-1">Added 419 redirect flow to login page for expired sessions.</span>
                        <span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">March-11-2026</span>
                    </li>
                    <li class="flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                        <span class="min-w-0 flex-1">Removed hardcoded password defaults from compose config.</span>
                        <span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">March-11-2026</span>
                    </li>
                    <li class="flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                        <span class="min-w-0 flex-1">Added "My Rewards" page.</span>
                        <span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">March-11-2026</span>
                    </li>
                    <li class="flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                        <span class="min-w-0 flex-1">Added optimistic rendering for favorite icon via Ajax POST, rollback on failure. Deal cards have been rewritten into a reuseable component.</span>
                        <span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">March-12-2026</span>
                    </li>
                    <li class="flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                        <span class="min-w-0 flex-1">Working on the deals page for a specific merchant (/stores/{merchant_id}). Running migration to index the merchant id in the deals table to avoid full table scans.</span>
                        <span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">March-13-2026</span>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggle = document.getElementById('devLogToggle');
            var panel = document.getElementById('devLogPanel');
            var label = document.getElementById('devLogToggleLabel');
            var chevron = document.getElementById('devLogChevron');

            if (!toggle || !panel || !label || !chevron) {
                return;
            }

            toggle.addEventListener('click', function () {
                var expanded = toggle.getAttribute('aria-expanded') === 'true';
                var nextExpanded = !expanded;

                toggle.setAttribute('aria-expanded', String(nextExpanded));
                panel.hidden = !nextExpanded;
                panel.classList.toggle('hidden', !nextExpanded);
                label.textContent = nextExpanded ? 'Hide dev log' : 'Show dev log';
                chevron.classList.toggle('rotate-180', nextExpanded);
            });
        });
    </script>
</body>
</html>
