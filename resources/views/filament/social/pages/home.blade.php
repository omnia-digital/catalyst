{{--@extends('filament.layouts.default-page-layout')--}}

<x-filament-panels::page>
    <div>
        <div class="flex bg-neutral">
            <!-- SideMenu -->
            {{--        <livewire:social::layouts.module-navigation class=""/>--}}

            <!-- Main Content -->
            <div class="lg:pl-64 w-full flex flex-col">
                <div>
                    <div class="min-h-screen">
                        <!-- Page content -->
                        <div class="flex-1">
                            @hasSection('full-width-header')
                                <div class="">
                                    @yield('full-width-header')
                                </div>
                            @endif
                            <div>
                                <div class="grid grid-cols-12 gap-4 sm:mr-4">
                                    <div class="col-span-12 sm:col-span-8 2xl:col-span-9">

{{--                                        @section('banner-with-sidebar')--}}
                                        <div class="w-full mb-4">
                                            <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
                                                {{--            <div class="absolute inset-0 grayscale">--}}
                                                {{--                <img class="h-full w-full object-cover"--}}
                                                {{--                     src="https://source.unsplash.com/random?community&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"--}}
                                                {{--                     alt="Community platform">--}}
                                                {{--                <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>--}}
                                                {{--            </div>--}}
                                                {{--            <div class="relative px-4 py-12 sm:px-6 sm:py-12 lg:py-12 lg:px-8 text-center">--}}
                                                {{--                <x-library::heading.1 class="text-center uppercase" text-size="text-5xl">{{ Translate::get('Community') }}</x-library::heading.1>--}}
                                                {{--                <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">{{ Translate::get('Welcome to the community.') }}</p>--}}
                                                {{--                </p>--}}
                                                {{--                @auth--}}
                                                {{--                    <x-library::button x-data=""--}}
                                                {{--                                       x-on:click.prevent="$openModal('create-team')"--}}
                                                {{--                                       class="mx-auto mt-4 px-16 py-2">--}}
                                                {{--                        {{ Translate::get('Create a new Team') }}--}}
                                                {{--                    </x-library::button>--}}
                                                {{--                @else--}}
                                                {{--                    <x-library::button wire:click.prevent="showAuthenticationModal" class="mx-auto mt-4 px-16 py-2">--}}
                                                {{--                        {{ Translate::get('Create a new Team') }}--}}
                                                {{--                    </x-library::button>--}}
                                                {{--                @endauth--}}
                                                {{--            </div>--}}
                                                {{--            <livewire:teams.create-team-modal/>--}}
                                            </div>
                                        </div>

                                        <div class="ml-4 mr-4 lg:ml-0 sm:mr-0">

{{--                                            @section('content')--}}
                                                <div>
                                                    <div>
                                                        <!-- Recommended Teams -->
                                                        <div>
                                                            {{--                                {{ $recommendedTeams }}--}}
                                                        </div>

                                                        @if (\OmniaDigital\CatalystCore\Facades\Catalyst::isModuleEnabled('feeds'))
                                                            <div class="my-4">
                                                                <x-library::heading.3>{{ Translate::get('Latest News') }}</x-library::heading.3>
                                                                @foreach ($newsRssFeeds->take(1) as $newsFeed)
                                                                    <livewire:feeds::feed-section :type="$newsFeed[0]" :feed-url="$newsFeed->url"
                                                                                                  :show-description="false" :show-link-to-news-page="true"/>
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
                                                        @if (config('app.modules.social.map'))
                                                            <div class="mt-4 justify-center mx-auto max-w-post-card-max-w">
                                                                {{--                    <x-library::heading.3>{{ Translate::get('Team Map') }}</x-library::heading.3>--}}
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
{{--                                            @endsection--}}
                                        </div>
                                    </div>
                                    <x-sidebar-column class="mt-4 hidden sm:block col-span-4 2xl:col-span-3"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
    </div>
</x-filament-panels::page>
