<div
    x-data="{
        currentEpisode: {{ Js::from($initialEpisode->toPlayer()) }},

        selectEpisode(episode) {
            if (episode.playback_url === this.currentEpisode.playback_url) {
                return;
            }

            this.currentEpisode = episode;

            // Setup new player with selected episode.
            $dispatch('embed-player', {
                type: 'setup',
                episode: this.currentEpisode,
                autoPlay: true
            });
        }
    }"
    class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8"
    style="background-color: {{ $player->layoutSetting('background_color') }}"
>
    <div id="omnia-embed-player" class="relative w-full mx-auto mb-8">
        <x-jwplayer x-show="currentEpisode" id="embed-player" :episode="$initialEpisode->toPlayer($player)" enableAnalytics/>
        <x-alert.info x-show="!currentEpisode">Video is processing.</x-alert.info>
    </div>

    @include('episode.embed-gallery')
</div>
