@extends('social::livewire.layouts.main-layout')

@section('content')
    <div>
        <!-- Page Heading -->
        <div class="flex space-x-6">
            <div class="mx-auto max-w-2xl">
                <div class="mt-0">
                    <div class="mx-auto">
                        <livewire:social::news-feed-editor />

{{--                        <div x-data="setup()">--}}
{{--                            <ul class="flex justify-center items-center my-4">--}}
{{--                                <template x-for="(tab, index) in tabs" :key="tab.id">--}}
{{--                                    <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"--}}
{{--                                        :class="activeTab===tab.id ? 'text-black font-bold border-black' : ''"--}}
{{--                                        @click="activeTab = tab.id"--}}
{{--                                        x-html="tab.title + notifications"></li>--}}
{{--                                </template>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                        <div class="mt-4 space-y-4">
                            <livewire:social::news-feed/>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- Featured Section -->
{{--                    <livewire:social::map/>--}}

                    <!-- Posts -->
                    <ul role="list" class="mt-6 space-y-4">
                        @foreach ($activities as $activity)
                            <livewire:social::partials.activity-list-item :activity="$activity"/>
                        @endforeach
                    </ul>
                </div>
            </div>
            <x-sidebar-column class="max-w-sm"/>
        </div>

        <livewire:media-manager :handleUploadProcess="false"/>
    </div>
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
                        component: 'social.top-projects'
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
                notifications: '<span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">3</span>',
            }
        }
    </script>
@endpush
