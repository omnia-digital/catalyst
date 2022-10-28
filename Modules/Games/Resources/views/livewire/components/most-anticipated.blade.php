<div wire:init="loadMostAnticipated" class="most-anticipated-container space-y-10 mt-8">
    @forelse ($mostAnticipated as $game)
        @if(is_string($game))
            {{ $game }}
        @else
{{--            <livewire:games::components.game-card-small :game="$game"/>--}}
        @endif
    @empty
        {{--        @foreach (range(1, 4) as $game)--}}
        {{--            <livewire:games::components.game-card-small-skeleton />--}}
        {{--        @endforeach--}}
    @endforelse
</div>
