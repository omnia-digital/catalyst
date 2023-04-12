<div wire:init="load" class="recently-reviewed-container mt-8 grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @forelse ($recentlyReviewed as $game)
        <livewire:games::components.game-card :game="$game" />
    @empty
        @foreach (range(1, 3) as $game)
            <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
                <div class="relative flex-none">
                    <div class="bg-gray-700 w-32 lg:w-48 h-40 lg:h-56"></div>
                </div>
                <div class="ml-6 lg:ml-12">
                    <div class="inline-block text-lg font-semibold leading-tight text-transparent bg-gray-700 rounded mt-4">Title goes here for game</div>
                    <div class="mt-8 space-y-4 hidden lg:block">
                        <span class="text-transparent bg-gray-700 rounded inline-block">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum.</span>
                        <span class="text-transparent bg-gray-700 rounded inline-block">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum.</span>
                        <span class="text-transparent bg-gray-700 rounded inline-block">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum.</span>
                    </div>
                </div>
            </div> <!-- end game -->
        @endforeach
    @endforelse
</div>

@push('scripts')
    @include('games::_rating', [
        'event' => 'reviewGameWithRatingAdded'
    ])
@endpush
