@props([
    'item',
])

<li {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="group block aspect-w-10 aspect-h-7 w-full relative overflow-hidden rounded-lg  cursor-pointer">
        <img class="object-cover w-full h-48" src="{{ $item->thumbnail }}" alt="{{ $item->title }}"/>

        <div class="px-4 py-4 transition-transform ease-in-out bg-neutral-dark hover:translate-y-1 hover:scale-y-150 hover:bg-primary duration-75">
            <h4 class="mb-3 text-xl font-semibold tracking-tight text-white-text-color">{{ $item->title }}</h4>
        </div>
    </div>
    {{--    <div class="{{ 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-primary' }} group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-neutral overflow-hidden cursor-pointer relative">--}}
    {{--        <img--}}
    {{--            src="{{ $item->thumbnail }}"--}}
    {{--            alt="{{ $item->title }}"--}}
    {{--            class="{{ 'group-hover:opacity-75' }} object-cover pointer-events-none"--}}
    {{--        >--}}

    {{--        @if ($item->isLive())--}}
    {{--            <div class="absolute top-0 left-0">--}}
    {{--                <div class="flex items-center w-16 h-4 bg-gray-800 py-3 rounded-md text-center opacity-80">--}}
    {{--                    <div class="ml-2 w-3 h-3 bg-red-600 rounded-full"></div>--}}
    {{--                    <p class="text-xs ml-1 uppercase text-white-text-color font-medium">Live</p>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        @endif--}}
    {{--    </div>--}}
    {{--    <p class="mt-2 block text-sm font-medium text-dark-text-color line-clamp-2 pointer-events-none">{{ $item->title }}</p>--}}
</li>
