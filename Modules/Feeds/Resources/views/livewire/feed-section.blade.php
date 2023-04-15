<div wire:init="ready">
    @if ($loaded)
        <div class="space-y-2">
            <div>
                <div class="">
                    @if ($showTitle)
                        <h2 class="mb-0">
                            <div class="py-1">
                                <div>
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-6">
                                            @if ($feed->get_image_url())
                                                @if ($feed->get_image_link())
                                                    <a href="{{ $feed->get_image_link() }}" target="_blank">
                                                        @endif
                                                        <img src="{{ $feed->get_image_url() }}" class="h-12 rounded-full object-cover"/>
                                                        @if ($feed->get_image_link())
                                                    </a>
                                                @endif
                                            @endif

                                            @if ($showDescription)
                                                <div>
                                                    <a href="{{ $feed->get_link() }}" target="_blank" class="flex items-center text-neutral-dark space-x-2 hover:underline">
                                                        <x-library::heading.2 class="text-heading-default-color uppercase tracking-wide font-semibold">{!! $this->sanitize($feed->get_title())
                                                         !!}</x-library::heading.2>
                                                    </a>
                                                    <p>{{ $feed->get_description() }}</p>
                                                </div>
                                            @endif


                                        </div>
                                        {{--                                <div class="inline-flex items-center text-md">--}}
                                        {{--                                    <button type="button" class="inline-flex items-center px-4 py-2 rounded-full bg-primary text-white-text-color text-sm tracking-wide font-medium hover:opacity-75">--}}
                                        {{--                                        <span>Follow</span>--}}
                                        {{--                                    </button>--}}
                                        {{--                                </div>--}}

                                        @if ($showLinkToNewsPage)
                                            <div>
                                                <a href="{{ route('feeds.index') }}" target="_self" class="flex
                                                items-center
                                                text-neutral-dark space-x-2 hover:underline">
                                                    <p class="text-heading-default-color uppercase tracking-wide font-semibold">{{ Trans::get('See more News') }}</p>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </h2>
                    @endif
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 mt-4">
                        @foreach ($feed->get_items(0,4) as $item)
                            <a href="{{ route('feeds.show', app(\Modules\Feeds\Services\FeedManager::class)->encryptFeedPayload($item)) }}">
                                <div class="w-full bg-secondary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
                                     style="background-image: url({{ $this->getDefaultItemImage($item) }}); background-size: cover; background-repeat: no-repeat;">
                                    <div class="h-80 rounded"></div>
                                    <div class="space-y-2 p-4 bg-secondary rounded absolute bottom-0 right-0 left-0">
                                        <div class="flex justify-between">
                                            <p class="text-heading-default-color font-semibold text-base">{!! $this->sanitize($item->get_title()) !!}</p>
                                        </div>
                                        <div class="flex items-center text-base-text-color">
                                            @empty($item->get_authors())
                                            @else
                                                @foreach ($item->get_authors() as $author)
                                                    @if (!empty($author->name ?? $author->email ?? null))
                                                        by {{ $author->name ?? $author->email }}
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                        <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $this->sanitize($item->get_description())
                                        }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
