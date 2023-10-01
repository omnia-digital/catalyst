@props([
    'id' => 'player-' . uniqid(),
    'audio',
])

<div
        x-data="{
        player: null,

        setupPlayer(id) {
            this.player = jwplayer(id).setup({
                file: '{{ $audio }}',
                width: document.getElementById('{{ $id }}').parentElement.clientWidth,
	            height: 40,
	            skin: {
	                menus: {
	                    text: '#111111'
	                },
	                controlbar: {
	                    icons: '#111111',
	                    text: '#111111',
	                    background: 'white',
	                },
	                timeslider: {
	                    progress: '#E9AF6B',
	                    rail: '#ebebeb'
                    }
	            }
            });
        }
    }"
        x-init="() => {
        setupPlayer('{{ $id }}');
    }"
        wire:key="player-audio-script-{{ time() }}-{{ $id }}"
>
</div>

<div id="{{ $id }}" wire:key="player-audio-{{ time() }}-{{ $id }}"></div>

@once
    @push('scripts')
        <script src="//content.jwplatform.com/libraries/Wq6HOAmw.js"></script>
    @endpush
@endonce
