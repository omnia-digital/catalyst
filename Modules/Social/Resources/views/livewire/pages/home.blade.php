@extends('social::livewire.layouts.pages.default-page-layout')

@section('banner-with-sidebar')
    <div class="w-full mb-4">
        <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
            <div class="absolute inset-0 grayscale">
                <img class="h-full w-full object-cover"
                     src="https://source.unsplash.com/random?gaming&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                     alt="People working on laptops">
                <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
            </div>
            <div class="relative px-4 py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
                <x-library::heading.1 class="text-center uppercase" text-size="text-5xl">{{ Trans::get('Community') }}</x-library::heading.1>
                <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">Welcome to the new home of the gaming community. Make new friends, connect, and find your
                    favorite news,
                    games, and
                    communities.</p>
                </p>
            </div>
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
                    <x-library::heading.3>{{ Trans::get('Team Map') }}</x-library::heading.3>
                    <livewire:social::pages.teams.map class=""/>
                </div>
            @endif
            <div class="mt-4 mx-auto max-w-post-card-max-w">
                <livewire:social::news-feed/>
            </div>
        </div>
    </div>

    <livewire:social::delete-post-modal />
    <livewire:media-manager :handleUploadProcess="false" />
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
