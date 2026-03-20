<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <p class="max-w-sm text-base text-zinc-700">
                        Built with Laravel.
                    </p>
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

        <section class="mx-auto mt-4 w-full max-w-4xl overflow-hidden rounded-2xl border border-zinc-300 bg-white/80 shadow-sm">
            <div class="flex items-center justify-between border-b border-zinc-200 px-4 py-3 sm:px-6">
                <h2 class="text-sm font-semibold tracking-wide text-zinc-900">Development Log</h2>
                <button
                    type="button"
                    id="devLogAddBtn"
                    class="flex h-7 w-7 items-center justify-center rounded-lg border border-zinc-300 bg-white text-zinc-500 transition hover:bg-zinc-100 hover:text-zinc-700"
                    title="Add dev log entry">
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                    </svg>
                </button>
            </div>
            <div class="px-4 py-4 sm:px-6">
                <ul id="devLogList" class="space-y-3 text-sm text-zinc-700">
                    @forelse ($devLogs as $log)
                        <li class="flex items-baseline justify-between gap-2 rounded-lg border border-zinc-200 bg-zinc-50 px-3 py-2">
                            <span class="min-w-0 flex-1">{{ $log->message }}</span>
                            <span class="shrink-0 whitespace-nowrap text-right text-xs text-zinc-500">{{ $log->log_date->format('d-m-Y') }}</span>
                        </li>
                    @empty
                        <li class="text-zinc-400 text-center py-2">No log entries yet.</li>
                    @endforelse
                </ul>
            </div>
        </section>

        <section class="mx-auto mt-3 hidden w-full max-w-4xl overflow-hidden rounded-2xl border border-[#d7c7b2] bg-[#f4ede2] text-zinc-800 shadow-sm">
            <div class="flex items-center justify-between border-b border-[#e3d7c7] px-4 py-3 sm:px-6">
                <div class="flex items-center gap-3">
                    <span id="kafkaStreamStatusDot" class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                    <h2 class="text-sm font-semibold tracking-wide">Live Kafka Stream</h2>
                </div>
                <span id="kafkaStreamStatusText" class="text-xs uppercase tracking-[0.18em] text-zinc-500"></span>
            </div>
            <div class="px-4 py-4 sm:px-6">
                <div id="kafkaStreamBar" class="flex max-h-64 min-h-20 flex-col gap-2 overflow-y-auto rounded-xl border border-[#e3d7c7] bg-[#fbf7f1] px-3 py-3 text-sm shadow-inner">
                    <span data-kafka-empty class="text-zinc-500">Waiting for Kafka messages...</span>
                </div>
            </div>
        </section>
    </main>

    <!-- Dev Log Add Modal -->
    <div id="devLogModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
        <div class="w-full max-w-sm rounded-2xl border border-zinc-300 bg-white p-6 shadow-xl">
            <h3 class="text-lg font-semibold text-zinc-900">Add Dev Log Entry</h3>

            <div id="devLogModalError" class="mt-3 hidden rounded-lg border border-red-300 bg-red-50 p-2 text-sm text-red-700"></div>

            <form id="devLogForm" class="mt-4 space-y-4">
                <div>
                    <label for="devlog-username" class="mb-1 block text-sm font-medium text-zinc-700">Username</label>
                    <input id="devlog-username" type="text" autocomplete="off"
                        class="block w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 outline-none transition focus:border-zinc-900"
                        placeholder="Username">
                </div>
                <div>
                    <label for="devlog-password" class="mb-1 block text-sm font-medium text-zinc-700">Password</label>
                    <input id="devlog-password" type="password" autocomplete="off"
                        class="block w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 outline-none transition focus:border-zinc-900"
                        placeholder="Password">
                </div>
                <div>
                    <label for="devlog-message" class="mb-1 block text-sm font-medium text-zinc-700">Log message</label>
                    <textarea id="devlog-message" rows="3"
                        class="block w-full rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-zinc-900 outline-none transition focus:border-zinc-900"></textarea>
                </div>
                <div class="flex items-center gap-3 pt-1">
                    <button type="submit" id="devLogSubmitBtn"
                        class="rounded-xl bg-zinc-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-zinc-800">
                        Add Entry
                    </button>
                    <button type="button" id="devLogCancelBtn"
                        class="rounded-xl border border-zinc-300 bg-white px-4 py-2.5 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-50">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
