<div wire:init="loadComingSoon" class="most-anticipated-container space-y-10 mt-8">
    @forelse ($comingSoon as $game)
        <livewire:games::components.game-card-small :game="$game"/>
    @empty
        @foreach (range(1, 4) as $game)
            <livewire:games::components.game-card-small-skeleton/>
        @endforeach
    @endforelse
</div>
