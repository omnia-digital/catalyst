<div class="game flex">
    <a href="{{ $game->details->url }}" target="_blank"><img src="{{ $game->details->getCoverUrl() }}" alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150"></a>
    <div class="ml-4">
        <a href="{{ $game->details->url }}" target="_blank" class="hover:text-gray-300">{{ $game->details->name }}</a>
        <div class="text-gray-400 text-sm mt-1">{{ $game->details->releaseDate }}</div>
    </div>
</div>
