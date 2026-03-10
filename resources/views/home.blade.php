<x-layout>
    <section class="mx-auto max-w-6xl px-6 py-16 text-center">
        <h2 class="text-4xl font-bold tracking-tight leading-tight md:text-5xl">
            Stop paying full price.
        </h2>

        <p class="mx-auto mt-4 max-w-2xl text-base text-zinc-600 md:text-lg">
            Verified discounts across brands and stores to cash in on extra savings
        </p>

        <form action="{{ route('home') }}" method="GET"
            class="mx-auto mt-8 flex w-full max-w-2xl overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="flex flex-1 items-center gap-2 px-5">
                <svg class="h-4 w-4 flex-shrink-0 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0Z" />
                </svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search brands, stores, products..."
                    class="flex-1 bg-transparent py-4 text-base placeholder:text-zinc-400 focus:outline-none">
            </div>

            <button type="submit"
                class="bg-zinc-900 px-6 text-sm font-semibold text-white transition hover:bg-zinc-800 sm:px-8">
                Search
            </button>
        </form>
    </section>

    <section class="bg-zinc-100 px-6 py-10">
        <div class="mx-auto max-w-6xl">
            <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">
                        {{ $search !== '' ? 'Search Results' : 'Featured Deals' }}
                    </h3>
                    <p class="mt-1 text-sm text-zinc-500">
                        @if ($search !== '')
                            {{ $deals->count() }} result{{ $deals->count() === 1 ? '' : 's' }} for "{{ $search }}"
                        @else
                            Verified discounts trending right now.
                        @endif
                    </p>
                </div>
            </div>

            @if ($deals->isEmpty())
                <div class="rounded-2xl border border-zinc-200 bg-white p-8 text-center text-zinc-600">
                    No deals matched "{{ $search }}". Try a different keyword.
                </div>
            @else
                <div class="grid w-full gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($deals as $deal)
                        <x-deal-card
                            :deal-url="$deal->deal_url"
                            :brand-color="$deal->merchant->brand_color ?? '#4f46e5'"
                            :logo-url="$deal->merchant->logo_url"
                            :merchant-name="$deal->merchant_name"
                            :title="$deal->title"
                            :description="$deal->description"
                            :show-favorite="auth()->check()"
                            :favorite-route="route('favorites.toggle', $deal->id)"
                            :is-favorited="auth()->check() ? auth()->user()->favoritedDeals->contains($deal->id) : false"
                            :link-whole-card="false"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-6 py-16">
        <h3 class="mb-8 text-2xl font-semibold tracking-tight">
            Browse by Category
        </h3>

        <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
            @foreach (['Electronics', 'Fashion', 'Home', 'Dining'] as $cat)
                <a href="#"
                    class="rounded-xl border border-zinc-200 bg-white p-6 text-center text-sm font-medium hover:border-indigo-300 hover:text-indigo-600 transition">
                    {{ $cat }}
                </a>
            @endforeach
        </div>
    </section>
</x-layout>
