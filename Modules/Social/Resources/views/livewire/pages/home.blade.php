@extends('social::livewire.layouts.pages.default-page-layout')

@section('banner-with-sidebar')
    <div class="w-full mb-4">
        <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
{{--            <div class="absolute inset-0 grayscale">--}}
{{--                <img class="h-full w-full object-cover"--}}
{{--                     src="https://source.unsplash.com/random?community&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"--}}
{{--                     alt="Community platform">--}}
{{--                <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>--}}
{{--            </div>--}}
{{--            <div class="relative px-4 py-12 sm:px-6 sm:py-12 lg:py-12 lg:px-8 text-center">--}}
{{--                <x-library::heading.1 class="text-center uppercase" text-size="text-5xl">{{ Trans::get('Community') }}</x-library::heading.1>--}}
{{--                <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">{{ Trans::get('Welcome to the community.') }}</p>--}}
{{--                </p>--}}
{{--                @auth--}}
{{--                    <x-library::button x-data=""--}}
{{--                                       x-on:click.prevent="$openModal('create-team')"--}}
{{--                                       class="mx-auto mt-4 px-16 py-2">--}}
{{--                        {{ Trans::get('Create a new Team') }}--}}
{{--                    </x-library::button>--}}
{{--                @else--}}
{{--                    <x-library::button wire:click.prevent="showAuthenticationModal" class="mx-auto mt-4 px-16 py-2">--}}
{{--                        {{ Trans::get('Create a new Team') }}--}}
{{--                    </x-library::button>--}}
{{--                @endauth--}}
{{--            </div>--}}
            <livewire:teams.create-team-modal/>
        </div>
    </div>
@endsection

@section('content')
    <div>
        <div>
            <!-- Recommended Teams -->
            <div>
                {{--                {{ $recommendedTeams }}--}}
            </div>

            @if(Platform::isModuleEnabled('games'))
                <div class="my-4">
                    <x-library::heading.3>{{ Trans::get('Latest Gaming News') }}</x-library::heading.3>
                    @foreach($newsRssFeeds->take(1) as $newsFeed)
                        <livewire:games::components.feed-section :type="$newsFeed[0]" :feed-url="$newsFeed[1]" :show-description="false" :show-link-to-news-page="true"/>
                    @endforeach
                </div>
            @endif

            <div class="mx-auto max-w-post-card-max-w">
                <livewire:social::news-feed-editor/>
            </div>
            {{--                        <div x-data="setup()">--}}
            {{--                            <ul class="flex justify-center items-center my-4">--}}
            {{--                                <template x-for="(tab, index) in tabs" :key="tab.id">--}}
            {{--                                    <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"--}}
            {{--                                        :class="activeTab===tab.id ? 'text-base-text-color font-bold border-black' : ''"--}}
            {{--                                        @click="activeTab = tab.id"--}}
            {{--                                        x-html="tab.title + notifications"></li>--}}
            {{--                                </template>--}}
            {{--                            </ul>--}}
            {{--                        </div>--}}

            <!-- Featured Section -->
            @if(config('app.modules.social.map'))
                <div class="mt-4 justify-center mx-auto max-w-post-card-max-w">
{{--                    <x-library::heading.3>{{ Trans::get('Team Map') }}</x-library::heading.3>--}}
                    <livewire:social::components.teams.map :places="$places"/>
                </div>
            @endif
            <div class="mt-4 mx-auto max-w-post-card-max-w">
                <livewire:social::news-feed/>
            </div>
        </div>
    </div>

    <livewire:social::delete-post-modal/>
    <livewire:media-manager :handleUploadProcess="false"/>
    <livewire:authentication-modal/>
@endsection
@push('scripts')
    <script>
        function setup() {
            return {
                activeTab: 0,
                tabs: [
                    {
                        id: 0,
                        title: 'Feed',
                        component: 'social.posts'
                    },
                    {
                        id: 1,
                        title: 'Top',
                        component: 'social.top-teams'
                    },
                    {
                        id: 2,
                        title: 'Newest',
                        component: 'social.newest'
                    },
                    {
                        id: 4,
                        title: 'Undiscovered',
                        component: 'social.undiscovered'
                    },
                ],
                notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white-text-color bg-black rounded-full">3</span>',
            }
        }
    </script>
@endpush
