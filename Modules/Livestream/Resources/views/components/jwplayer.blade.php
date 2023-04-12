@props([
    'id' => 'player-' . uniqid(),
    'episode',
    'enableAnalytics' => false
])

<div
    x-data="{
        player: null,

        episode: {{ Js::from($episode) }},

        enableAnalytics: '{{ $enableAnalytics }}' != false,

        setupPlayer(id, autoPlay = false) {
            this.player = jwplayer(id).setup({
                file: this.episode.playback_url,
                autostart: autoPlay,
                preload: 'auto',
                width: '100%',
                mute: false,
                volume: 100,
                image: this.episode.thumbnail
            });

            // Initialize Mux Data monitoring
            if (this.enableAnalytics) {
                initJWPlayerMux(this.player, {
                    debug: false,
                    data: {
                        env_key: '{{ config('services.mux.environment_key') }}',

                        sub_property_id: this.episode.sub_property_id,
                        episode_id: this.episode.episode_id,
                        player_name: this.episode.player_name,
                        player_version: this.episode.player_version,

                        video_id: this.episode.video_id,
                        video_title: this.episode.video_title,
                    }
                });
            }
        },

        setupPlayListener(episode) {
            if (!this.enableAnalytics) {
                return;
            }

            this.player.on('play', (e) => {
                // Dispatch video view event
                fetch('{{ route('dispatch-video-view') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({episode_id: episode.episode_id})
                });
            });
        }
    }"
    x-init="() => {
        setupPlayer('{{ $id }}');
        setupPlayListener(episode);

        window.addEventListener('{{ $id }}', e => {
            const eventType = e.detail.type;

            if (eventType === 'play') {
                player.play();
            }
            else if (eventType === 'stop') {
                player.stop();
            }
            else if (eventType === 'setup') {
                episode = e.detail.episode;
                setupPlayer('{{ $id }}', e.detail.autoPlay);
                setupPlayListener(e.detail.episode);
            }
        });
    }"
    wire:key="player-script-{{ time() }}-{{ $id }}"
>
</div>

<div id="{{ $id }}" wire:key="player-{{ time() }}-{{ $id }}"></div>

@once
    @push('scripts')
        <script src="https://cdn.jwplayer.com/libraries/Wq6HOAmw.js"></script>
        <script src="https://src.litix.io/jwplayer/4/jwplayer-mux.js"></script>
    @endpush
@endonce
