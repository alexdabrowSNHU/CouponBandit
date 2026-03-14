<x-layout>
    <section class="border-b border-zinc-200 bg-zinc-50 py-10">
        <div class="mx-auto max-w-4xl px-4 text-center">

            <div class="mx-auto max-w-md rounded-xl border border-zinc-200 bg-white px-6 py-6 shadow-sm">
                <h1 class="text-3xl font-bold text-zinc-900">Top Deals</h1>
                <p class="mt-2 text-sm text-zinc-600">
                    Today's best coupons and promo codes
                </p>
            </div>
    </section>

    <div class="mx-auto w-full max-w-6xl px-4 pt-8 pb-16 sm:px-6">
        <div class="grid w-full gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($deals as $deal)
                <x-deal-card :deal-url="$deal->deal_url" 
                    :brand-color="$deal->merchant->brand_color ?? '#4f46e5'"
                    :logo-url="$deal->merchant->logo_url" 
                    :merchant-name="$deal->merchant_name" 
                    :title="$deal->title"
                    :description="$deal->description" 
                    :show-favorite="auth()->check()"
                    :favorite-route="route('favorites.toggle', $deal->id)"
                    :is-favorited="auth()->check() ? auth()->user()->favoritedDeals->contains($deal->id) : false"
                    :link-whole-card="false" />
            @endforeach
        </div>
    </div>
</x-layout>