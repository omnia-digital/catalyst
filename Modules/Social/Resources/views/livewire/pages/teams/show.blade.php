@php use Carbon\Carbon; @endphp
@extends('social::livewire.layouts.pages.team-profile-layout')


@section('content')
    <div class="flex-1 grid grid-cols-12 gap-1 md:gap-6 lg:mr-3 xl:mr-5 mt-4">
        <div class="col-span-12 lg:col-span-6 xl:col-span-6">
            {{--            <x-library::heading.3 class="pl-3 mb-4">Discussion</x-library::heading.3>--}}
            <div class="space-y-4">
                @if ($this->canViewTeamContent)
                    <livewire:social::news-feed-editor :team="$team"/>
                    {{-- Featured --}}
                    @if ($team->sampleImages()->count())
                        <div class="col-span-12 bg-neutral">
                            {{--                    <x-library::heading.4 class="ml-4 mt-1 uppercase" text-size="text-xs">Featured</x-library::heading.4>--}}
                            <x-library::heading.3 class="pl-2">Featured</x-library::heading.3>
                            <div class="flex flex-col">
                                <div class="space-x-4 h-50 pt-2" style="scrollbar-width: thin;">
                                    <div class="flex space-x-2 rounded">
                                        @foreach ($team->sampleImages()->take(3) as $media)
                                            <div class="rounded-lg flex justify-center items-center relative cursor-pointer {{ ($media->id === $displayID) ? 'ring-2
                            ring-neutral-dark'
                            : '' }}"
                                                 wire:click="setImage({{ $media->id }})">
                                                {{ $media->img()->attributes(['class' => 'h-48 w-96 object-cover rounded-lg']) }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <livewire:social::news-feed :team="$team"/>
                @else
                    <div class="card p-1 col-span-12">
                        <div class="py-28 px-12 flex flex-col justify-center items-center text-center">
                            <x-heroicon-o-lock-closed class="w-20 h-20"/>
                            <p class="text-lg">{{ Trans::get('You must be a member of this Team to view content and participate in discussions.') }}</p>
                            <div class="my-2">
                                <x-teams.apply-button :team="$team"/>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{--        <div class="col-span-7 grid grid-cols-12 gap-6 lg:gap-4 mr-4">--}}
        <div class="sticky top-[220px] h-screen col-span-12 lg:col-span-6 xl:col-span-6 lg:mr-3 xl:mr-4">
            <div class="grid grid-cols-12 gap-4">
                {{-- Overview  --}}
                <div class="col-span-12 2xl:col-span-6">
                    <div class="flex flex-col flex-1 bg-secondary rounded">
                        <div class="h-44 bg-primary"
                             style="background-image: url({{ $team->mainImage()->getFullUrl() ?? config('teams.defaults.cover_photo') }}); background-size: cover; background-repeat: no-repeat;"
                        ></div>
                        <div class="p-4 flex flex-col flex-1">
                            <p class="text-sm flex-1">{{ $team->summary }}</p>
                            <div class="text-xs grid grid-cols-4 grid-rows-4 gap-1 items-center">
                                @if ($team->start_date)
                                    <span class="col-span-1 text-gray-400 text-2xs uppercase">Launch Date</span>
                                    <div class="col-span-3 flex items-center space-x-2">
                                        <x-heroicon-o-calendar class="w-4 h-4"/>
                                        <span>{{ Carbon::parse($team->start_date)->toFormattedDateString() }}</span>
                                    </div>
                                @endif
                                @if ($team->end_date)
                                    <span class="col-span-1 text-gray-400 text-2xs uppercase">End Date</span>
                                    <div class="col-span-3 flex items-center space-x-2">
                                        <x-heroicon-o-calendar class="w-4 h-4"/>
                                        <span>{{ Carbon::parse($team->end_date)->toFormattedDateString() }}</span>
                                    </div>
                                @endif
                                @if ($team->location_short)

                                    <span class="col-span-1 text-gray-400 text-2xs uppercase">Location:</span>
                                    <div class="col-span-3 flex items-center space-x-2">
                                        <x-library::icons.icon name="fa-light fa-location-dot" class="w-4 h-4"/>
                                        <span>{{ $team->location_short ?? "Not Set" }}</span>
                                    </div>
                                @endif
                                <span class="col-span-1 text-gray-400 text-2xs uppercase ">Organizer:</span>
                                <div class="col-span-3 flex items-center space-x-2">
                                    <x-heroicon-s-user-circle class="w-4 h-4"/>
                                    <span>{{ $team?->owner?->name }}</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                @foreach ($additionalInfo as $item)
                                    <div>
                                        <p class="text-light-text-color text-2xs">{{ $item }}</p>
                                        <p class="text-dark-text-color font-semibold text-lg">{{ $team->$item()->count() }}</p>
                                    </div>
                                @endforeach

                                <div>
                                    <p class="text-light-text-color text-2xs">subscribers</p>
                                    <p class="text-dark-text-color font-semibold text-lg">{{ number_format($team->subscribersCount()) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- People --}}
                <div class="col-span-12 2xl:col-span-6 space-y-6">
                    <livewire:social::partials.user-status-list :team="$team"/>
                </div>


                <!-- Team Relevence -->
                {{--                <div class="col-span-12">--}}
                {{--                    --}}{{-- <div>--}}
                {{--                        <div class="text-base-text-color font-semibold">--}}
                {{--                            <p class="text-sm">Is this team relevant to you?</p>--}}
                {{--                        </div>--}}
                {{--                        <div class="mt-4 bg-white p-4">--}}
                {{--                            <p class="text-dark-text-color text-sm">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ratione consequuntur hic aperiam adipisci cupiditate repellat quibusdam molestias praesentium sunt velit! Totam illum vero deleniti, sint est illo atque sequi quo.</p>--}}
                {{--                        </div>--}}
                {{--                    </div> --}}

                {{--                </div>--}}

                @if ($team->content)
                    <div class="card p-4 col-span-12">
                        <x-library::heading.3>{{ Trans::get('About') }}</x-library::heading.3>
                        <div x-data="{readMore: false, longText: @js(strlen($team->content) > 410)}"
                             class="relative">
                            <p class="text-dark-text-color transition-all duration-300 overflow-y-hidden"
                               :class="(longText && readMore) ? 'h-full max-h-96' : 'max-h-24'">{!! $team->content !!}</p>
                            <div x-show="longText && !readMore"
                                 class="bg-gradient-to-t from-white to-transparent absolute bottom-1 left-4 right-2 pt-8">
                                <a class="block w-full text-right"
                                   href="#"
                                   @click.prevent="readMore = !readMore">{{ Trans::get('Read More') }}</a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Map --}}
                {{--            <div>--}}
                {{--                <div class="text-base-text-color font-semibold">--}}
                {{--                    <x-library::heading.3>{{ \Trans::get('Location') }}</x-library::heading.3>--}}
                {{--                </div>--}}
                {{--                <div class="mt-4 bg-white">--}}
                {{--                    --}}{{-- <x-library::map.google class="h-96" :places="$this->places"/> --}}
                {{--                    <x-library::map.mapbox id="team-map" class="h-96 z-10" :places="$this->places" mapStyle="mapbox://styles/mapbox/dark-v10"/>--}}
                {{--                </div>--}}
                {{--            </div>--}}

                <!-- Team Languages -->
                @if ($team->languages)
                    <div class="card col-span-6 p-4">
                        <x-library::heading.3>{{ Trans::get('Languages') }}</x-library::heading.3>
                        <div class="mt-2">
                            <p class="text-dark-text-color">{{ $team->languages }}</p>
                        </div>
                    </div>
                @endif

                {{-- Team Awards --}}
                {{--            <div>--}}
                {{--                <div class="flex justify-between items-center text-base-text-color font-semibold">--}}
                {{--                    <x-library::heading.3>{{ \Trans::get('Awards') }}</x-library::heading.3>--}}
                {{--                    @if ($team->awards()->count())--}}
                {{--                        <a href="{{ route('social.teams.awards', $team) }}" class="text-xs flex items-center">{{ \Trans::get('See all') }}--}}
                {{--                            <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>--}}
                {{--                        </a>--}}
                {{--                    @endif--}}
                {{--                </div>--}}
                {{--                <div class="mt-4 flex space-x-2">--}}
                {{--                    @forelse ($team->awards()->take(2)->get() as $award)--}}
                {{--                        <x-awards-banner class="flex-1" :award="$award"/>--}}
                {{--                    @empty--}}
                {{--                        <div class="bg-white flex-1 p-4">--}}
                {{--                            <p class="text-dark-text-color">{{ \Trans::get('No awards to show.') }}</p>--}}
                {{--                        </div>--}}
                {{--                    @endforelse--}}
                {{--                </div>--}}
                {{--            </div>--}}

                <div class="col-span-12">
                    <livewire:reviews::review-list :model="$team"/>
                </div>
            </div>
        </div>

        @if ($this->canViewTeamContent)
            <livewire:reviews::create-review-modal :model="$team"/>
            <livewire:media-manager :handleUploadProcess="false"/>
        @endif

        {{-- Add Awards Modal --}}
        @if ($this->canViewTeamContent)
            <div>
                <x-library::modal id="add-awards-modal" maxWidth="2xl">
                    <x-slot name="title">{{ Trans::get('Add Awards') }}</x-slot>
                    <x-slot name="content">
                        @if ($userToAddAwardsTo)
                            <div class="w-full flex flex-col">
                                @forelse ($this->getRemainingAwards($userToAddAwardsTo) as $award)
                                    <div class="mr-4 mt-2 flex items-center">
                                        <input type="checkbox" wire:model="awardsToAdd" value="{{ $award->id }}"
                                               class="mr-2" name="award-item-{{ $award->id }}"
                                               id="award-item-{{ $award->id }}">
                                        <label for="award-item-{{ $award->id }}"
                                               class="bg-secondary p-2 flex flex-1 items-center">
                                            <x-library::icons.icon :name="$award->icon" class="h-4 w-4 mr-4"/>
                                            <p>{{ ucfirst($award->name) }}</p>
                                        </label>
                                    </div>
                                @empty
                                    <div class="w-full px-4 py-2 text-sm bg-white p-2 flex items-center">
                                        <p>{{ Trans::get('No other awards are available') }}</p>
                                    </div>
                                @endforelse

                            </div>
                        @else
                            <div class="w-full flex flex-col space-y-2">
                                <div class="w-full bg-white h-4"></div>
                                <div class="w-full bg-white h-4"></div>
                                <div class="w-full bg-white h-4"></div>
                                <div class="w-full bg-white h-4"></div>
                            </div>
                        @endif
                    </x-slot>
                    <x-slot name="actions">
                        @if ($userToAddAwardsTo)
                            <x-library::button
                                    wire:click="addAward({{ $userToAddAwardsTo->id }})">{{ Trans::get('Add') }}</x-library::button>
                        @endif
                    </x-slot>
                </x-library::modal>
            </div>
        @endif
    </div>
@endsection
