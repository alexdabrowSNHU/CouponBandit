<x-layout>
    <section class="max-w-6xl mx-auto px-6 py-16">
        <h1 class="text-3xl font-bold tracking-tight">Stores</h1>
        <p class="mt-3 text-zinc-500">Browse stores with active deals and cashback offers.</p>

        <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
           
            @foreach ($merchants as $merchant)
                <a href="{{ route('merchants.show', ['id' => $merchant->id]) }}">
                    <article class="rounded-2xl border border-zinc-200 bg-white p-5">
                        <h2 class="text-lg font-semibold">{{ $merchant->name }}</h2>
                        <p class="mt-2 text-sm text-zinc-500">{{ $merchant->description }}</p>
                    </article>
                </a>
            @endforeach
        </div>
    </section>
</x-layout>