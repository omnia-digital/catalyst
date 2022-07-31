@extends('social::livewire.layouts.pages.default-page-layout')

@section('content')
    <div class="">
        <div class="mt-0">
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
            <div class="mt-4 justify-center">
                <livewire:social::pages.teams.map/>
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
