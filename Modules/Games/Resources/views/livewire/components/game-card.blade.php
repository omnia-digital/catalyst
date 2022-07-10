<div wire:click.prevent.stop="showGame"
     class="w-full bg-primary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black" style="background-image: url({{ $game->getCoverUrl() }});
     background-size:
     cover; background-repeat: no-repeat;">
    <div class="h-80 rounded"></div>
    <div class="space-y-2 p-4 bg-primary rounded absolute bottom-0 right-0 left-0">
        <div class="flex justify-between">
            <p class="text-dark-text-color font-semibold text-base">{{ $game->name }}            {{ dd($game) }}
                </p>

            <div class="flex items-center">
                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                <p>{{ $game->getVideos()->count() }}</p>
            </div>

            <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $game->summary }}</p>
        </div>
    </div>
    @if ($game->rating)
        <div id="{{ $game->slug }}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full" style="right: -20px; bottom: -20px">
        </div>
asdfs
        @push('scripts')
            @include('games::_rating', [
                'slug' => $game->slug,
                'rating' => $game->rating,
                'event' => null,
            ])
        @endpush
    @endif
    <div class="text-gray-400 mt-1">
        {{--        {{ $game->platforms }}--}}
    </div>
</div>
