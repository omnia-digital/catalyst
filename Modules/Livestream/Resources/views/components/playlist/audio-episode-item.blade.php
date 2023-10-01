@props([
'episode',
'selected' => false,
'first' => false,
'public' => true
])

@php
    $class = $selected ? 'ring-2 ring-offset-2 ring-blue-500' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-blue-500';
    $class .= 'col-span-1 shadow-md rounded-md';
    if ($first) {
        $class .= ' border-2 border-gold';
    }
@endphp

<li {{ $attributes->merge(['class' => $class]) }}>
    <div class="items-center bg-white py-5 px-9 rounded-lg lg:mx-auto">
        {{--<div class="max-w-7xl mt-8 py-5 px-8 rounded-lg b lg:mx-auto ">--}}
        <div class="">
            <div class="lg:flex">
                <ul class="items-center text-gray-400 text-sm lg:inline-flex lg:space-x-4 font-Montserrat">
                    @if ($episode->date_recorded)
                        <li class="text-gray-500"><i class="fad fa-calendar-alt mr-1"></i>
                            {{ $episode->date_recorded->format("M j, Y") }}
                        </li>
                    @endif
                    @if ($episode->main_passage)
                        <li><i class="fad fa-bible lg:mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->main_passage }}</span>
                        </li>
                    @endif
                    @if ($episode->mainSpeaker)
                        <li><i class="fas fa-user lg:mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->mainSpeaker->name }}</span>
                        </li>
                    @endif
                    @if ($episode->category)
                        <li><i class="fad fa-folder-open lg:mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->category->name }}</span>
                        </li>
                    @endif
                    @if ($episode->seriesLabels)
                        <li><i class="fad fa-album-collection lg:mr-1"></i>
                            <span class="hover:underline cursor-pointer text-gray-500">{{ $episode->seriesLabels }}</span>
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
                @if ($first)
                    <div class="flex-1 items-end sm:text-left lg:text-right lg:pl-12 pt-4 lg:pt-0">
                        <span class="bg-gold rounded-full py-2 px-4 text-sm font-weight-500 line-height-15 font-Montserrat text-white font-style-normal ">Latest Message</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="w-full text-left mt-2 font-Montserrat">
            <h3 class="text-xl font-bold">{{ Str::limit($episode->title, 155) }}</h3>
        </div>

        @if ($episode->video?->getPlaybackUrl())
            <div class="py-2 w-full">
                <x-jwplayer-audio audio="{{ $episode->video?->getPlaybackUrl() }}"/>
            </div>
        @endif

        @if (count($episode->media))
            <div class="inline-flex items-center text-gray-500">
                Attachments:
                <ul class="ml-3 flex items-center space-x-3">
                    @foreach ($episode->media->sortBy('mime_type') as $attachment)
                        <li class="items-center">
                            <a href="{{ route('attachments.download', $attachment->id) }}"
                               download="{{ $attachment->name }}" target="_blank">
                                {{--                                {{ $attachment->name }}--}}
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
            <p class="my-2 flex-1  text-gray-500">{{ $episode->description }}</p>
        </div>
    </div>
</li>


