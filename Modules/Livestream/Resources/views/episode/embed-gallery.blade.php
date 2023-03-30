<div id="omnia-embed-gallery">
    <ul role="list" class="grid grid-cols-{{ $player->layoutSetting('columns') }} gap-x-4 gap-y-8 sm:gap-x-6 xl:gap-x-8" style="list-style: none !important; border-style: none !important;">
        @foreach ($episodes as $episode)
            <x-episode.grid-item
                x-on:click.prevent="selectEpisode({{ Js::from($episode->toPlayer()) }})"
                :episode="$episode"
                :embed="true"
            />
        @endforeach
    </ul>

    <div class="mt-6">
        {{ $episodes->links('episode.embed-pagination') }}
    </div>
</div>
