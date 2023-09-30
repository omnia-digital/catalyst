<div>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="-ml-4 mb-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $channel->name }}
                </h3>
            </div>

            @if (Auth::check() && Gate::check('update', $channel))
                <div class="ml-4 mt-4 flex-shrink-0">
                    <x-form.button-link :to="route('channels.update', $channel)">Edit Channel</x-form.button-link>
                </div>
            @endif
        </div>

        @if ($currentEpisode)
            <div class="relative w-full mx-auto mb-8">
                <x-jwplayer :episode="$currentEpisode->toPlayer($channel->player)" enableAnalytics/>
            </div>
        @endif

        <ul role="list"
            class="grid grid-cols-{{ $player->layoutSetting('columns') }} gap-x-4 gap-y-8 sm:gap-x-6 xl:gap-x-8">
            @foreach ($episodes as $episode)
                @if ($episode->id !== $currentEpisode->id)
                    <x-episode.grid-item
                            wire:key="episode-{{ $episode->id }}"
                            wire:click="selectEpisode({{ $episode->id }})"
                            :episode="$episode"
                    />
                @endif
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $episodes->onEachSide(1)->links() }}
        </div>
    </div>
</div>
