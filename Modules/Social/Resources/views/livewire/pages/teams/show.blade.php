@extends('social::livewire.layouts.pages.team-profile-layout')


@section('content')
<div class="flex space-x-4 mt-4">
    <div class="space-y-4">
        <div class="lg:grid lg:grid-rows-1 lg:grid-cols-3 lg:gap-4">
            <div class="col-span-2 row-span-1 flex flex-col min-h-[512px]">
                <div class="flex-1 bg-black"
                    @if ($team->sampleImages()->count())
                        style="background-image: url({{ $displayUrl }}); background-size: contain; background-position: center; background-repeat: no-repeat;"
                    @endif
                ></div>
                @if ($team->sampleImages()->count())
                <div class="flex w-full mt-1 space-x-1 overflow-x-scroll h-40" style="scrollbar-width: thin;">
                    <div class="flex h-36 pl-2">
                        @foreach ($team->sampleImages() as $media)
                            <span class="w-40 h-32 mr-2 mt-2 flex justify-center items-center relative pr-1 last:pr-0 cursor-pointer hover:ring-4 hover:ring-neutral-dark active:ring-4 active:ring-neutral-dark focus:ring-4 focus:ring-neutral-dark {{ ($media->id === $displayID) ? 'ring-2 ring-neutral-dark' : '' }}" wire:click="setImage({{ $media->id }})">
                                {{ $media->img()->attributes(['class' => 'max-w-[152px] max-h-[120px]']) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="col-span-1 row-span-1 flex flex-col">
                <div class="flex flex-col flex-1 bg-primary rounded">
                    <div
                        class="h-44 bg-secondary"
                        @if ($team->mainImage()->count())
                            style="background-image: url({{ $team->mainImage()->getFullUrl() }}); background-size: cover; background-repeat: no-repeat;"
                        @endif
                    ></div>
                    <div class="p-[15px] flex flex-col flex-1">
                        <p class="text-sm flex-1">{{ $team->summary }}</p>
                        <div class="text-xs grid grid-cols-4 grid-rows-4 gap-1 items-center">
                            <span class="col-span-1 text-gray-400 text-xxs uppercase">Launch Date</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <x-heroicon-o-calendar class="w-4 h-4"/>
                                <span>{{ \Carbon\Carbon::parse($team->start_date)->toFormattedDateString() }}</span>
                            </div>
                            <span class="col-span-1 text-gray-400 text-xxs uppercase">Location:</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <x-heroicon-o-location-marker class="w-4 h-4"/>
                                <span>{{ $team->location_short ?? "Not Set"}}</span>
                            </div>
                            <span class="col-span-1 text-gray-400 text-xxs uppercase ">Organizer:</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                <x-heroicon-s-user-circle class="w-4 h-4"/>
                                <span>{{ $team->owner->name }}</span>
                            </div>
                            {{-- <span class="col-span-1 text-gray-400 text-xxs uppercase">Reviews:</span>
                            <div class="col-span-3 flex items-center space-x-2">
                                {{-- Review score algorithm not set
                                    <div class="bg-black flex items-center rounded-md mr-1 p-1">
                                    <div class="flex items-center text-white text-xs font-semibold">
                                        <x-heroicon-s-star class="w-4 h-4" />
                                        {{ $team->reviewScore ?? '3758' }}
                                    </div>
                                </div>
                                <span class="text-gray-400 text-xxs">{{ $team->reviewStatus ?? 'Overwhelmingly Positive' }} ({{ /* $team->reviews()->count */'296,418' }})</span>
                            </div> --}}
                        </div>
                        <div class="flex justify-between items-center">
                            @foreach ($additionalInfo as $item)
                                <div>
                                    <p class="text-light-text-color text-xxs">{{ $item }}</p>
                                    <p class="text-dark-text-color font-semibold text-lg">{{ $team->$item()->count() }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if ($team->tags()->count() > 0)
                    <div class="flex justify-start space-x-2 mt-2">
                        @foreach($team->tags as $tag)
                            <x-library::tag class=" bg-gray-700 text-xxs text-white uppercase">{{ $tag->name }}</x-library::tag>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
            <div class="lg:grid lg:grid-rows-1 lg:grid-cols-3 lg:gap-4">
                <div class="col-span-2 row-span-1 space-y-6 flex flex-col">
                    @if ($team->content)
                        <div class="flex-1 flex flex-col">
                            <p class="text-black font-semibold">{{ \Trans::get('About this Team') }}</p>
                            <div
                                    x-data="{readMore: false, longText: @js(strlen($team->content) > 410)}"
                                    class="mt-4 bg-white p-4 relative"
                            >
                                <p class="text-dark-text-color transition-all duration-300 overflow-y-hidden" :class="(longText && readMore) ? 'h-full max-h-96' : 'max-h-24'">{{ $team->content }}</p>
                                <div x-show="longText && !readMore"
                                    class="bg-gradient-to-t from-white to-transparent absolute bottom-1 left-4 right-2 pt-8">
                                    <a class="block w-full text-right"
                                        href="#"
                                        @click.prevent="readMore = !readMore">{{ \Trans::get('Read More') }}</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Post Tile -->
                    @if ($this->recentPosts->count())
                        <div>
                            <div class="flex justify-between items-center text-black font-semibold">
                                <p class="text-sm">{{ \Trans::get('Posts') }}</p>
                                <a href="#" class="text-xs flex items-center">{{ \Trans::get('Read More') }}
                                    <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                                </a>
                            </div>
                            <div class="space-y-2">
                                @foreach (\Modules\Social\Models\Post::take(2)->get() as $post)
                                    <div wire:click.prevent.stop="showPost({{ $post }})"
                                         class="bg-primary border border-neutral-light rounded p-4 flex space-x-4 hover:cursor-pointer hover:ring-1 hover:ring-black">
                                        <div class="w-1/3 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat rounded-md">
                                        </div>
                                        <div class="w-2/3 space-y-2">
                                            <p class="text-dark-text-color font-semibold text-xs">{{ $post->title }}</p>
                                            <div class="flex items-center text-base-text-color">
                                                <x-heroicon-o-calendar class="h-5 w-5 mr-2"/>
                                                <span class="text-neutral-900 text-xs">{{ $post->created_at->toFormattedDateString() }}</span>
                                            </div>
                                            <p class="text-light-text-color text-xs line-clamp-2">{{ $post->body }}</p>
                                            <div class="text-base-text-color text-xs flex items-center -space-x-1 pt-6">
                                                <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1">
                                                <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=2">
                                                <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=3">
                                                <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=4">
                                                <img class="h-6 w-6 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=5">
                                                <div class="h-6 w-6 rounded-full bg-neutral-light flex justify-center items-center text-xxs p-2">+5</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-span-1 row-span-1 space-y-6">
                    <!-- Team Relevence -->
                    {{-- <div>
                        <div class="text-black font-semibold">
                            <p class="text-sm">Is this team relevant to you?</p>
                        </div>
                        <div class="mt-4 bg-white p-4">
                            <p class="text-dark-text-color text-sm">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione consequuntur hic aperiam adipisci cupiditate repellat quibusdam molestias praesentium sunt velit! Totam illum vero deleniti, sint est illo atque sequi quo.</p>
                        </div>
                    </div> --}}
                    <!-- Team Location -->
                    <div>
                        <div class="text-black font-semibold">
                            <p class="text-sm">{{ \Trans::get('Location') }}</p>
                        </div>
                        <div class="mt-4 bg-white">
                            <x-library::map.google class="h-96" :places="$this->places"/>
                        </div>
                    </div>
                    <!-- Team Languages -->
                    @if ($team->languages)
                        <div>
                            <div class="text-black font-semibold">
                                <p class="text-sm">{{ \Trans::get('Languages') }}</p>
                            </div>
                            <div class="mt-4 bg-white p-4">
                                <p class="text-dark-text-color">{{ $team->languages }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Team Awards -->
                    <div>
                        <div class="flex justify-between items-center text-black font-semibold">
                            <p class="text-sm">{{ \Trans::get('Awards') }}</p>
                            @if($team->awards()->count())
                                <a href="{{ route('social.teams.awards', $team) }}" class="text-xs flex items-center">{{ \Trans::get('See all') }}
                                    <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>
                                </a>
                            @endif
                        </div>
                        <div class="mt-4 flex space-x-2">
                            @forelse ($team->awards()->take(2)->get() as $award)
                                <x-awards-banner class="flex-1" :award="$award"/>
                            @empty
                                <div class="bg-white p-4">
                                    <p class="text-dark-text-color">{{ \Trans::get('No awards to show.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            {{-- <p class="text-black font-semibold">Team Reviews</p>
            <div class="lg:grid lg:grid-cols-2 lg:gap-4">
                <div class="col-span-1">
                    <div class="bg-white p-4">
                        <p class="text-xxs">Overall Reviews:</p>
                        <div class="flex items-center space-x-2 text-xxs">
                            <div class="bg-black flex items-center rounded-md mr-1 p-1">
                                <div class="flex items-center text-white">
                                    <x-heroicon-s-star class="w-4 h-4" />
                                    {{ $team->reviewScore ?? '3758' }}
                                </div>
                            </div>
                            <span class="text-gray-400">{{ $team->reviewStatus ?? 'Overwhelmingly Positive' }} ({{ /* $team->reviews()->count */'296,418' }})</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-xxs">Most Helpful Reviews</p>
                        <div class="flex justify-start items-start bg-primary border border-neutral-light p-4">
                            <div class="mr-2">
                                <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy" />
                            </div>
                            <div class="flex-1 space-y-2">
                                <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                                <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                            </div>
                            <div class="flex text-light-text-color">
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div class="bg-white p-4">
                        <p class="text-xxs">Recent Reviews:</p>
                        <div class="flex items-center space-x-2 text-xxs">
                            <div class="bg-black flex items-center rounded-md mr-1 p-1">
                                <div class="flex items-center text-white">
                                    <x-heroicon-s-star class="w-4 h-4" />
                                    {{ $team->reviewScore ?? '3758' }}
                                </div>
                            </div>
                            <span class="text-gray-400">{{ $team->reviewStatus ?? 'Overwhelmingly Positive' }} ({{ /* $team->reviews()->count */'2,418' }})</span>
                        </div>
                    </div>
                    <div>
                        <p>Recent Reviews</p>
                        <div class="flex justify-start items-start bg-primary border border-neutral-light p-4">
                            <div class="mr-2">
                                <img class="h-8 w-8 rounded-full" src="https://source.unsplash.com/24x24/?face&crop-face&v=1" alt="Arlene McCoy" />
                            </div>
                            <div class="flex-1 space-y-2">
                                <p class="text-dark-text-color font-semibold text-sm">Arlene McCoy</p>
                                <p class="text-light-text-color text-xs">Courtney was very helpful in setting up and an amazing person to be around!</p>
                            </div>
                            <div class="flex text-light-text-color">
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                                <x-heroicon-s-star class="h-5 w-5" />
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
