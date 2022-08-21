@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="">
        <div class="mt-0">
            <div class="w-full mb-4">
                <div class="relative shadow-xl sm:rounded-b-2xl sm:overflow-hidden">
                    <div class="absolute inset-0 grayscale">
                        <img class="h-full w-full object-cover"
                             src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=2830&q=80&sat=-100"
                             alt="People working on laptops">
                        <div class="absolute inset-0 bg-indigo-700 mix-blend-multiply"></div>
                    </div>
                    <div class="relative px-4 py-16 sm:px-6 sm:py-16 lg:py-16 lg:px-8">
                        <h1 class="text-center text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">
                            <span class="block text-white uppercase">{{ Trans::get('Community') }}</span>
                        </h1>
                        <p class="mt-6 max-w-lg mx-auto text-center text-xl text-indigo-200 sm:max-w-3xl">Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit
                            sunt amet fugiat veniam occaecat fugiat aliqua.</p>
                    </div>
                </div>
            </div>
            <!-- Recommended Teams -->
            <div>

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
            <div class="mt-4 justify-center mx-auto max-w-post-card-max-w">
                <x-library::heading.3>{{ Trans::get('Team Map') }}</x-library::heading.3>
                <livewire:social::pages.teams.map class=""/>
            </div>
            <div class="mt-4 mx-auto max-w-post-card-max-w">
                <livewire:social::news-feed/>
            </div>
        </div>
    </div>

    <livewire:media-manager :handleUploadProcess="false"/>
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
