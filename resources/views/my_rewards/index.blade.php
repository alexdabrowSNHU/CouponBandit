<x-layout>
    <div class="flex flex-col items-center justify-center min-h-screen py-12 px-6">
        <h1 class="text-3xl font-bold mb-4">My Saved Deals</h1>
        <p class="text-zinc-500 mb-10">still a work in progress</p>

        {{-- Added a grid wrapper so they aren't just one giant vertical list --}}
        <div class="grid w-full max-w-6xl gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($favorites as $favorite)
                <x-deal-card
                    :deal-url="$favorite->deal_url"
                    :brand-color="$favorite->merchant->brand_color ?? '#4f46e5'"
                    :logo-url="$favorite->merchant->logo_url"
                    :merchant-name="$favorite->merchant_name"
                    :title="$favorite->title"
                    :description="$favorite->description"
                    :link-whole-card="true"
                    :show-favorite="true"
                    :favorite-route="route('favorites.toggle', $favorite->id)"
                    :is-favorited="true"
                />
            @endforeach
        </div>

        @if($favorites->isEmpty())
            <div class="text-center py-20">
                <p class="text-zinc-500">You haven't saved any deals yet!</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block text-indigo-600 font-semibold">Browse Deals -></a>
            </div>
        @endif
    </div>
</x-layout>
