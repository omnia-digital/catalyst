@php use MarcReichel\IGDBLaravel\Models\PlatformLogo; @endphp
@php use MarcReichel\IGDBLaravel\Models\Keyword; @endphp
<a href="{{ $game->details->url }}" target="_blank">
    <div class="w-full bg-secondary  group relative hover:cursor-pointer hover:ring-1 hover:ring-primary" style="background-image: url({{
    $game->details?->getCoverUrl() }});
     background-size:
     cover; background-repeat: no-repeat;">
        <div class="h-80 rounded"></div>
        <div class="space-y-2 p-4 bg-secondary rounded absolute bottom-0 right-0 left-0">
            <div class="flex justify-between">
                <p class="text-dark-text-color font-semibold text-lg">{{ $game->details?->name }}</p>
                <div class="flex items-center">
                    <x-heroicon-o-film class="h-4 w-4 mr-2"/>
                    <p>{{ $game->details->getVideos()->count() }}</p>
                </div>
            </div>
            <div class="text-base-text-color">
                <div class="flex justify-between items-center">
                    {{ $game->details->first_release_date->format(config('app.default_date_format')) }}
                    <div class="flex justify-end space-x-4">
                        @if ($game->details->platforms)
                            @foreach ($game?->details->platforms as $platform)
                                @if (\MarcReichel\IGDBLaravel\Models\Catalyst::find($platform)->platform_logo)
                                    <img src="{{ PlatformLogo::find(\MarcReichel\IGDBLaravel\Models\Catalyst::find
                        ($platform)?->platform_logo)?->url }}" alt=""
                                         class="w-6 h-6"/>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
                <br/>
                {{ $game->details->total_rating_count }}
                <div class="flex-wrap space-x-1">
                    @foreach (collect($game->details->keywords)->take(3) as $keyword)
                        <div>
                            <x-library::tag
                                    text-size="xs">{{ Keyword::find($keyword)?->name }}</x-library::tag>
                        </div>
                    @endforeach
                </div>
            </div>
            <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $game->details->summary }}</p>
        </div>
        @if ($game->details->rating)
            <div id="{{ $game->details->slug }}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full"
                 style="right: -20px; bottom: -20px">
            </div>
            @push('scripts')
                @include('games::_rating', [
                    'slug' => $game->details->slug,
                    'rating' => $game->details->rating,
                    'event' => null,
                ])
            @endpush
        @endif
        <div class="text-gray-400 mt-1">
            {{--        {{ $game->details->platforms }}--}}
        </div>
    </div>
</a>
