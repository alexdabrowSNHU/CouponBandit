<x-layout>
	<section class="border-b border-zinc-200 bg-zinc-50 py-10">
		<div class="mx-auto max-w-5xl px-4 text-center sm:px-6">
			<div class="mx-auto max-w-2xl rounded-xl border border-zinc-200 bg-white px-6 py-6 shadow-sm">
				<h1 class="text-3xl font-bold text-zinc-900">Categories</h1>
				<p class="mt-2 text-sm text-zinc-600">
					Browse coupon categories and see where the most active deals are right now.
				</p>
			</div>
		</div>
	</section>

	<section class="mx-auto w-full max-w-6xl px-4 pb-16 pt-8 sm:px-6">
		<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
			@foreach ($categories as $category)
				<article class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm transition hover:border-zinc-300 hover:shadow-md">
					<div class="flex items-start justify-between gap-4">
						<h2 class="text-lg font-semibold text-zinc-900">{{ $category['name'] }}</h2>
						<span class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-600">
							{{ $category['merchant_count'] }} {{ 
								Illuminate\Support\Str::plural('store', $category['merchant_count'])
							}}
						</span>
					</div>

					<p class="mt-3 text-sm text-zinc-600">
						{{ $category['active_deal_count'] }} active {{ 
							Illuminate\Support\Str::plural('deal', $category['active_deal_count'])
						}}
					</p>

					@if ($category['merchants']->isNotEmpty())
						<ul class="mt-4 space-y-2 border-t border-zinc-100 pt-4">
							@foreach ($category['merchants']->take(4) as $merchant)
								<li class="flex items-center justify-between text-sm">
									<a href="{{ route('merchants.show', ['id' => $merchant->id]) }}"
										class="font-medium text-zinc-800 hover:text-zinc-900">
										{{ $merchant->name }}
									</a>
									<span class="text-zinc-500">{{ $merchant->active_deals_count }} active</span>
								</li>
							@endforeach
						</ul>
					@else
						<p class="mt-4 border-t border-zinc-100 pt-4 text-sm text-zinc-500">No stores yet in this category.</p>
					@endif
				</article>
			@endforeach
		</div>
	</section>

</x-layout>