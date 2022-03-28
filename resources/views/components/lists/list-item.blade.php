@props([
    'selected' => false,
    'episode'
])

@php
    $class = $selected ? 'ring-2 ring-offset-2 ring-secondary' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-secondary';
    $class .= ' col-span-1 flex shadow-sm rounded-md cursor-pointer';
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <div class="group block w-1/3 aspect-w-10 aspect-h-2 rounded-l-md bg-neutral overflow-hidden relative">
        <img class="{{ $selected ? '' : 'group-hover:opacity-75' }} object-cover pointer-events-none" src="{{ $episode->thumbnail }}" alt="{{ $episode->title }}">

        @if ($episode->isLive())
            <div class="absolute top-0 left-0">
                <div class="flex items-center w-16 h-8 bg-gray-800 py-3 rounded-md text-center opacity-80">
                    <div class="ml-2 w-3 h-3 bg-red-600 rounded-full"></div>
                    <p class="text-sm ml-1 uppercase text-white font-medium">Live</p>
                </div>
            </div>
        @endif
    </div>
    <div class="flex-1 flex items-center justify-between border-t border-r border-b border-gray-200 bg-primary rounded-r-md">
        <div class="px-4 py-4 sm:px-6 w-full">
            <div class="flex items-center justify-between">
                <p class="font-medium text-secondary truncate">
                    {{ Str::limit($episode->title, 40) }}
                </p>
                <div class="ml-2 flex-shrink-0 flex">
                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        <span class="hidden xl:block xl:mr-1">Duration: </span>
                        {{ $episode->formattedDuration }}
                    </p>
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    @if ($episode->mainSpeaker)
                        <p class="flex items-center text-sm text-gray-500">
                            <x-heroicon-s-user class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                            {{ $episode->mainSpeaker->name }}
                        </p>
                    @endif
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                    <x-heroicon-s-calendar class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"/>
                    <time datetime="2020-01-07">{{ $episode->date_recorded->format('M jS, Y') }}</time>
                </div>
            </div>
            <div class="mt-2 sm:flex sm:justify-between">
                <div class="sm:flex">
                    <p class="flex items-center space-x-2 text-sm text-gray-500">
                        <span>Published</span>
                        <span>
                            @if($episode->is_published)
                                <x-heroicon-s-check-circle class="h-5 w-5 text-green-500"/>
                            @else
                                <x-heroicon-s-x-circle class="h-5 w-5 text-red-500"/>
                            @endif
                        </span>
                        <span class="flex items-center space-x-1">
                            @if ($episode->media_count)
                                <x-heroicon-s-paper-clip class="w-4 h-4"/>
                                <span>{{ $episode->media_count }}</span>
                            @endif
                        </span>
                    </p>
                </div>
                <div class="text-gray-500">
                    <span>{{ number_format($episode->views) }} views</span>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-sm text-gray-500 line-clamp-2">{{ $episode->description }}</p>
            </div>
        </div>
    </div>
</li>
