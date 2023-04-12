@props([
    'selected' => false,
    'episode',
    'embed' => false
])

<li {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="{{ $selected ? 'ring-2 ring-offset-2 ring-blue-500' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-blue-500' }} group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 overflow-hidden cursor-pointer relative">
        <img
            src="{{ $episode->thumbnail }}"
            alt="{{ $episode->title }}"
            class="{{ $selected ? '' : 'group-hover:opacity-75' }} object-cover pointer-events-none"
        >

        @if ($episode->isLive())
            <div class="absolute top-0 left-0">
                <div class="flex items-center w-16 h-4 bg-gray-800 py-3 rounded-md text-center opacity-80">
                    <div class="ml-2 w-3 h-3 bg-red-600 rounded-full"></div>
                    <p class="text-xs ml-1 uppercase text-white font-medium">Live</p>
                </div>
            </div>
        @endif
    </div>
    <p class="mt-2 block text-sm font-medium text-gray-900 line-clamp-2 pointer-events-none">{{ $episode->title }}</p>
    @if (!$embed)
        <p class="flex items-center justify-start text-sm space-x-2 font-medium text-gray-500 pointer-events-none">
            <span>
            @if ($episode->is_published)
                    <x-heroicon-s-check-circle class="h-5 w-5 text-green-500"/>
                @else
                    <x-heroicon-s-x-circle class="h-5 w-5 text-red-500"/>
                @endif
            </span>

            <span>
                {{ $episode->formattedDuration }}
            </span>
            @if ($episode->mainSpeaker)
                <span class="flex items-center">
                    <x-heroicon-s-user class="mr-1.5 h-4 w-4 text-gray-400"/>
                    {{ $episode->mainSpeaker->name }}
                </span>
            @endif
        </p>
    @endif
    <p class="flex justify-start items-center space-x-1 text-sm font-medium text-gray-500 pointer-events-none">
        <span>{{ number_format($episode->views) }} views</span>

        @if ($episode->media_count)
            <span class="flex items-center"><i class="items-center text-3xs fas fa-circle"></i></span>
            <x-heroicon-s-paper-clip class="w-4 h-4"/>
            <span>{{ $episode->media_count }}</span>
        @endif

        <span class="flex items-center"><i class="items-center text-3xs fas fa-circle"></i></span>
        <span>{{ $episode->date_recorded->format('m/j/y') }}</span>
    </p>
</li>
