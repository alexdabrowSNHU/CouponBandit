{{-- filepath: c:\Users\alexd\Desktop\CouponBandit\resources\views\stores\show.blade.php --}}
<x-layout>
    <style>
        .store-main-content-spacing {
            margin-top: 1rem;
        }

        .store-main-content-layout {
            flex-direction: column;
        }

        .store-main-sidebar {
            width: 100%;
        }

        /* Hide the top header strip/logo block rendered by x-deal-card. */
        .no-strip-cards .group > :first-child {
            display: none;
        }

        /* Compact card density once the top strip is removed. */
        .no-strip-cards .group {
            min-height: 0 !important;
        }

        .no-strip-cards .group > .flex {
            padding: 0.875rem 1rem;
        }

        .no-strip-cards .group h3 {
            min-height: 0 !important;
            margin-top: 0.2rem;
            line-height: 1.25;
        }

        .no-strip-cards .group p {
            margin-top: 0.5rem;
        }

        .store-deals-column {
            margin-top: 0;
        }

        .store-hero-logo {
            left: 2rem;
            top: 50%;
            bottom: auto;
            transform: translateY(-50%);
        }

        @media (min-width: 768px) {
            .store-main-content-layout {
                flex-direction: row;
            }

            .store-main-sidebar {
                width: 20rem;
                position: sticky;
                top: 6rem;
            }

            .store-deals-column {
                margin-top: -4.5rem;
            }

            .store-hero-logo {
                left: 3rem;
                top: auto;
                bottom: 0;
                transform: translateY(50%);
            }
        }

        @media (min-width: 768px) {
            .store-main-content-spacing {
                margin-top: 6rem;
            }
        }
    </style>
    <div class="pt-12 pb-10">
        <div class="container mx-auto max-w-screen-xl px-4 lg:px-0">
            {{-- White banner with overlapping logo --}}
            <div class="relative">
                <div class="absolute store-hero-logo">
                    <div
                        class="w-40 h-40 rounded-full border-4 border-white shadow-xl flex items-center justify-center overflow-hidden"
                        style="background-color: {{ $merchant->brand_color ?? '#4f46e5' }};">
                        @php
                            $rawLogo = $merchant->getRawOriginal('logo_url') ?: $merchant->logo_url;
                            $logoPath = ltrim((string) $rawLogo, '/');
                            $logoPath = preg_replace('#^storage/#', '', $logoPath);

                            if ($logoPath !== '' && !str_starts_with($logoPath, 'merchant_logos/')) {
                                $logoPath = 'merchant_logos/' . $logoPath;
                            }
                        @endphp

                        @if($logoPath !== '' && \Illuminate\Support\Facades\Storage::disk('public')->exists($logoPath))
                            <img src="{{ asset('storage/' . $logoPath) }}" alt="{{ $merchant->name }}"
                                class="w-full h-full object-contain object-[center_50%] p-4">
                        @else
                            <span class="text-white text-4xl font-bold">{{ substr($merchant->name, 0, 1) }}</span>
                        @endif
                    </div>
                </div>

                {{-- White banner with centered title --}}
                <div class="bg-white rounded-2xl shadow-sm border border-zinc-200 py-10 px-6 pl-56">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-center">
                        {{ $merchant->name }} Promo Codes & Coupons
                    </h1>
                    <p class="text-center text-zinc-600 mt-2 text-sm">50 VERIFIED OFFERS ON
                        {{ strtoupper(now()->format('F jS, Y')) }}
                    </p>
                </div>
            </div>

            {{-- Main content - flex instead of grid --}}
            <div class="store-main-content-spacing store-main-content-layout flex gap-6 items-start">
                {{-- Left column - sticky sidebar --}}
                <aside class="store-main-sidebar no-strip-cards space-y-6 flex-shrink-0">
                    <div class="rounded-2xl border border-zinc-200 bg-white p-5">
                        <h2 class="font-bold text-lg mb-4">Today's Top {{ $merchant->name }} Offers:</h2>
                        <ul class="space-y-1.5 text-sm text-zinc-700">
                            @foreach ($deals as $deal)
                                <x-deal-card
                                    :deal-url="$deal->deal_url"
                                    :brand-color="$deal->merchant->brand_color ?? '#4f46e5'"
                                    :logo-url="$deal->merchant->logo_url"
                                    :merchant-name="$deal->merchant_name"
                                    :title="$deal->title"
                                    :description="$deal->description"
                                    :link-whole-card="true" />
                            @endforeach

                        </ul>
                    </div>

                    <div class="rounded-2xl border border-zinc-200 bg-white p-5">
                        <h3 class="font-bold mb-3">Statistics</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-zinc-600">Total Offers</span>
                                <span class="font-semibold">50</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-zinc-600">Coupon Codes</span>
                                <span class="font-semibold">1</span>
                            </div>
                        </div>
                    </div>
                </aside>

                {{-- Right column - scrollable content --}}
                <section class="store-deals-column no-strip-cards flex-1 space-y-3">
                    @foreach ($deals as $deal)
                                <x-deal-card
                                    :deal-url="$deal->deal_url"
                                    :brand-color="$deal->merchant->brand_color ?? '#4f46e5'"
                                    :logo-url="$deal->merchant->logo_url"
                                    :merchant-name="$deal->merchant_name"
                                    :title="$deal->title"
                                    :description="$deal->description"
                                    :link-whole-card="true" />
                            @endforeach
                </section>
            </div>
        </div>
    </div>
</x-layout>