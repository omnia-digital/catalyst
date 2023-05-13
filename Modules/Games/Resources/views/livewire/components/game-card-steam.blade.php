<a href="{{ $game->details->url }}" target="_blank">
    <div class="w-full bg-primary group relative bg-black hover:cursor-pointer transition-all delay-75 duration-300 hover:scale-110 hover:z-10" style="background-image: url({{
    $game->details?->getCoverUrl() }});
     background-size:
     cover; background-repeat: no-repeat;">
        <div class="h-80 "></div>
{{--        <div class="py-1 px-3 bg-primary opacity-75 rounded-t absolute bottom-0 right-0 left-0">--}}
{{--            <div class="flex justify-between">--}}
{{--                <x-library::heading.4 class="text-white-text-color font-semibold text-md">{{ $game->details?->name }}</x-library::heading.4>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
</a>
