@props([
    'dealUrl',
    'brandColor' => '#4f46e5',
    'logoUrl' => null,
    'merchantName',
    'title',
    'description' => '',
    'showFavorite' => false,
    'favoriteRoute' => null,
    'isFavorited' => false,
    'linkWholeCard' => true,
])

@if ($linkWholeCard && !($showFavorite && $favoriteRoute))
    <a href="{{ $dealUrl }}" target="_blank" rel="noopener noreferrer"
        class="group flex h-full min-h-[208px] flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition-all duration-200 hover:border-zinc-300 hover:shadow-md">
        <div class="flex h-20 items-center justify-center border-b border-zinc-200 px-4"
            style="background-color: {{ $brandColor }};">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $merchantName }}" class="h-8 w-auto max-w-[170px] object-contain" loading="lazy">
            @else
                <span class="text-sm font-semibold text-white">{{ $merchantName }}</span>
            @endif
        </div>

        <div class="flex flex-1 flex-col p-4">
            <span class="text-base leading-normal font-semibold uppercase text-zinc-700 antialiased">
                {{ $merchantName }}
            </span>
            <h3 class="mt-1 min-h-[48px] text-xl font-semibold leading-tight text-zinc-900">
                {{ \Illuminate\Support\Str::limit($title, 52) }}
            </h3>
            <p class="mt-2 text-sm leading-snug text-zinc-600">
                {{ \Illuminate\Support\Str::limit(rtrim((string) $description, '.'), 74) }}
            </p>
        </div>
    </a>
@else
    <div
        class="group flex min-h-[208px] flex-col overflow-hidden rounded-xl border border-zinc-200 bg-white shadow-sm transition-all duration-200 hover:border-zinc-300 hover:shadow-md">
        <a href="{{ $dealUrl }}" target="_blank" rel="noopener noreferrer"
            class="flex h-20 flex-shrink-0 items-center justify-center border-b border-zinc-200 px-4"
            style="background-color: {{ $brandColor }};">
            @if ($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $merchantName }}" class="h-8 w-auto max-w-[170px] object-contain" loading="lazy">
            @else
                <span class="text-sm font-semibold text-white">{{ $merchantName }}</span>
            @endif
        </a>

        <div class="flex flex-1 flex-col p-4">
            <div class="flex items-center justify-between">
                <span class="text-base leading-normal font-semibold uppercase text-zinc-700 antialiased">
                    {{ $merchantName }}
                </span>

                @if ($showFavorite && $favoriteRoute)
                    <button type="button"
                        class="js-favorite-btn -mr-1 p-1 transition-transform hover:scale-110 active:scale-95"
                        data-favorite-url="{{ $favoriteRoute }}"
                        data-favorited="{{ $isFavorited ? '1' : '0' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="js-heart-filled h-5 w-5 text-red-500 drop-shadow-sm {{ $isFavorited ? '' : 'hidden' }}">
                            <path d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001Z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="js-heart-empty h-5 w-5 text-zinc-400 hover:text-red-400 {{ $isFavorited ? 'hidden' : '' }}">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </button>
                @endif
            </div>

            <a href="{{ $dealUrl }}" target="_blank" rel="noopener noreferrer" class="flex flex-1 flex-col">
                <h3 class="mt-1 min-h-[48px] text-xl font-semibold leading-tight text-zinc-900">
                    {{ \Illuminate\Support\Str::limit($title, 52) }}
                </h3>
                <p class="mt-2 text-sm leading-snug text-zinc-600">
                    {{ \Illuminate\Support\Str::limit(rtrim((string) $description, '.'), 74) }}
                </p>
            </a>
        </div>
    </div>
@endif
