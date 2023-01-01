@if($small)
    <div wire:init="load" class="most-anticipated-container space-y-10 mt-8">
        @forelse ($comingSoon as $game)
            <livewire:games::components.game-card-small :game="$game"/>
        @empty
            @foreach (range(1, 4) as $game)
                <livewire:games::components.game-card-small-skeleton/>
            @endforeach
        @endforelse
    </div>
@else
    <div wire:init="load" class="popular-games text-sm grid gap-1 grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7 pb-16">
        @forelse ($comingSoon as $game)
            <livewire:games::components.game-card :game="$game"/>
        @empty
            @foreach (range(1, 24) as $game)
                <livewire:games::components.game-card-skeleton/>
            @endforeach
        @endforelse
    </div> <!-- end popular-games -->
@endif

@push('scripts')
    @include('games::_rating', [
        'event' => 'gameWithRatingAdded'
    ])
@endpush
