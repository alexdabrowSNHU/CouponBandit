<x-layout>
    <section class="relative w-full overflow-hidden border-b border-zinc-200/80 bg-gradient-to-b from-zinc-50 via-white to-zinc-50">
        <div class="pointer-events-none absolute left-1/2 top-0 h-28 w-80 -translate-x-1/2 rounded-full bg-indigo-200/30 blur-3xl"></div>
        <div class="mx-auto max-w-6xl px-4 py-5 sm:px-6 sm:py-7">
            <div class="mx-auto max-w-xl rounded-2xl border border-white/70 bg-white/80 px-6 py-5 text-center shadow-[0_18px_40px_-32px_rgba(15,23,42,0.75)] ring-1 ring-zinc-200/60 backdrop-blur">
                <h1 class="mt-3 text-2xl font-bold tracking-tight text-zinc-900 sm:text-3xl translate-20">Top Deals</h1>
                <p class="mt-1 text-sm text-zinc-600">Today's best coupons and promo codes</p>
            </div>
        </div>
    </section>

    <div class="mx-auto w-full max-w-6xl px-4 pt-8 pb-16 sm:px-6">
        <div class="grid w-full gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($deals as $deal)
                @php
                    $brandColor = $deal->merchant->brand_color ?? '#4f46e5';
                @endphp

                <a href="{{ $deal->deal_url }}" target="_blank" rel="noopener noreferrer"
                    class="group flex h-full min-h-[208px] flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition-all duration-200 hover:border-zinc-300 hover:shadow-md">

                    <div class="flex h-20 items-center justify-center border-b border-zinc-200 px-4"
                        style="background-color: {{ $brandColor }};">
                        <div class="flex h-11 w-full max-w-[160px] items-center justify-center rounded-md bg-white/90 px-3 ring-1 ring-black/5">
                            <img src="{{ $deal->merchant->logo_url }}" alt="{{ $deal->merchant_name }}" class="h-7 w-full object-contain" loading="lazy">
                        </div>
                    </div>

                    <div class="flex flex-1 flex-col p-4">
                        <span class="text-[11px] font-semibold uppercase tracking-[0.1em] text-zinc-500">{{ $deal->merchant_name }}</span>
                        <h3 class="mt-1 min-h-[48px] text-xl font-semibold leading-tight text-zinc-900">
                            {{ \Illuminate\Support\Str::limit($deal->title, 52) }}
                        </h3>
                        <p class="mt-2 text-sm leading-snug text-zinc-600">
                            {{ \Illuminate\Support\Str::limit(rtrim($deal->description, '.'), 74) }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
