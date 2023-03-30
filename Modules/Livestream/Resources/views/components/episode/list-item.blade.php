@props([
    'selected' => false,
    'episode',
    'first' => false,
    'public' => false
])

@php
    $class = $selected ? 'ring-2 ring-offset-2 ring-blue-500' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-blue-500';
    $class .= ' col-span-1 flex shadow-md p-3 rounded-lg cursor-pointer bg-white';
    if ($first) {
        $class .= ' border-2 border-gold';
    }
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <div class="flex-1 pointer-events-none">
        @if ($episode->video)
            <div class="group w-full pointer-events-none rounded-xl overflow-hidden">
                <x-jwplayer class="pointer-events-none" :episode="$episode->toPlayer()"/>
            </div>
        @else
            <div class="group pointer-events-none w-full rounded-xl overflow-hidden aspect-w-10 aspect-h-2 relative">
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
        @endif
    </div>
    <div class="flex-1">
        <div class="bg-white px-4 py-1 rounded-lg lg:mx-auto">
            <div class="flex">
                <ul class="items-center text-gray-400 text-sm inline-flex space-x-4 font-Montserrat">
                    @if ($episode->date_recorded)
                        <li class="text-gray-500"><i class="fad fa-calendar-alt mr-1"></i>
                            {{ $episode->date_recorded->format("M j, Y") }}
                        </li>
                    @endif
                    @if ($episode->main_passage)
                        <li><i class="fad fa-bible mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->main_passage }}</span>
                        </li>
                    @endif
                    @if ($episode->mainSpeaker)
                        <li><i class="fas fa-user mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->mainSpeaker->name }}</span>
                        </li>
                    @endif
                    @if ($episode->category)
                        <li><i class="fad fa-folder-open mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->category->name }}</span>
                        </li>
                    @endif
                    @if ($episode->seriesLabels)
                        <li><i class="fad fa-album-collection mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->seriesLabels }}</span>
                        </li>
                    @endif
                    @if ($episode->formattedDuration)
                        <li>
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $episode->formattedDuration }}
                            </p>
                        </li>
                    @endif
                    @if (!$public)
                        <li>
                            @if ($episode->is_published)
                                <x-heroicon-s-check-circle class="h-5 w-5 text-green-500"/>
                            @else
                                <x-heroicon-s-x-circle class="h-5 w-5 text-red-500"/>
                            @endif
                        </li>
                    @endif
                </ul>
                @if (!empty($first))
                    <div class="flex-1 items-end text-right pl-12">
                        <span class="bg-gold rounded-full py-2 px-4 text-sm font-weight-500 line-height-15 font-Montserrat text-white font-style-normal ">Latest Message</span>
                    </div>
                @endif
            </div>

            <div class="w-full items-center text-left mt-2 font-Montserrat">
                <h3 class="text-xl font-bold">{{ Str::limit($episode->title, 155) }}</h3>
            </div>

            <div class="text-gray-500">
                <span>{{ number_format($episode->views) }} views</span>
            </div>

            @if (count($episode->media))
                <div class="inline-flex items-center text-gray-500">
                    Attachments:
                    <ul class="ml-3 flex items-center space-x-3">
                        @foreach ($episode->media->sortBy('mime_type') as $attachment)
                            <li class="items-center">
                                <a href="{{ route('attachments.download', $attachment->id) }}" download="{{ $attachment->name }}" target="_blank">
                                    <x-attachment-icon :for="$attachment->mime_type"/>
                                </a>
                            </li>
                        @endforeach

                        @foreach ($episode->staticMedia->sortBy('mime_type') as $attachment)
                            <li class="items-center">
                                <a href="{{ route('attachments.static-download', $attachment->id) }}" target="_blank">
                                    <x-attachment-icon :for="$attachment->mime_type"/>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <p class="my-2 flex-1 line-clamp-4 text-gray-500">{{ $episode->description }}</p>
            </div>
        </div>
    </div>
</li>
