@extends('games::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="w-full mb-4">
        <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
            <div class="absolute inset-0 grayscale">
                <img class="h-full w-full object-cover"
                     src="https://source.unsplash.com/random?gaming?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                     alt="People working on laptops">
                <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
                <x-library::heading.1 class="text-center text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">
                    <span class="block text-white uppercase">{{ Trans::get('News') }}</span>
                </x-library::heading.1>
                <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">See what's happening right now in gaming news.</p>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 space-y-6">
        @foreach($feeds as $feed)
            <div class="space-y-4">
                <div class="flex items-center space-x-6">
                    <x-library::heading.2 class="text-heading-default-color uppercase tracking-wide font-semibold">{{ $feed->get_title() }}</x-library::heading.2>

                    @if($feed->get_image_url())
                        @if($feed->get_image_link())
                            <a href="{{ $feed->get_image_link() }}" target="_blank">
                                @endif
                                <img src="{{ $feed->get_image_url() }}" class="h-12 rounded-full object-cover"/>
                                @if($feed->get_image_link())
                            </a>
                        @endif
                    @endif

{{--                    <div class="inline-flex items-center text-md">--}}
{{--                        <button type="button" class="inline-flex items-center px-4 py-2 rounded-full bg-secondary text-white-text-color text-sm tracking-wide font-medium hover:opacity-75">--}}
{{--                            <span>Follow</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
                </div>
                <p>{{ $feed->get_description() }}</p>

                <div class="grid grid-cols-4 gap-4">
                    @foreach($feed->get_items(0,4) as $item)
                        <a href="{{ $item->get_link() }}" target="_blank">
                            @if($item->get_media() && !empty($item->get_media()['url']))
                                <div class="w-full bg-primary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
                                     style="background-image: url({{ ($item->get_media() && $item->get_media()['url'])? $item->get_media()['url'] : 'https://source.unsplash.com/random?gaming'
                                  }}); background-size: cover;
                                 background-repeat: no-repeat;"
                                >
                            @else
                                <div class="w-full bg-primary border border-neutral-light rounded group relative bg-black hover:cursor-pointer hover:ring-1 hover:ring-black"
                                     style="background-image: url({{ ($item->get_thumbnail() && $item->get_thumbnail()['url'])? $item->get_thumbnail()['url'] : 'https://source.unsplash.com/random?gaming'
                          }}); background-size: cover;
                         background-repeat: no-repeat;"
                                >
                            @endif
                                            <div class="h-80 rounded"></div>
                                            <div class="space-y-2 p-4 bg-primary rounded absolute bottom-0 right-0 left-0">
                                                <div class="flex justify-between">
                                                    <p class="text-heading-default-color font-semibold text-base">{{$item->get_title()}}</p>
                                                    {{--                                        <div class="flex items-center">--}}
                                                    {{--                                            <x-heroicon-o-users class="h-4 w-4 mr-2" />--}}
                                                    {{--                                            <p>{{ $team->users_count ?? $team->users()->count() }}</p>--}}
                                                    {{--                                        </div>--}}
                                                </div>
                                                <div class="flex items-center text-base-text-color">
                                                    @empty($item->get_authors())
                                                    @else
                                                        @foreach($item->get_authors() as $author)
                                                            by {{ $author->get_name() }}
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <p class="text-light-text-color text-xs line-clamp-3 h-0 transition-all delay-75 duration-300 group-hover:h-13">{{ $item->get_description() }}</p>
                                            </div>
                                        </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
