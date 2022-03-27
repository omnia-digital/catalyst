@extends('social::livewire.layouts.main-layout')

@section('content')
    <div>
        <!-- Page Heading -->
        <div class="xl:grid xl:grid-cols-9 xl:gap-9">
            <div class="xl:col-span-6">
                <div x-data="setup()">
                    <ul class="flex justify-center items-center my-4">
                        <template x-for="(tab, index) in tabs" :key="tab.id">
                            <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"
                                :class="activeTab===tab.id ? 'text-black font-bold border-black' : ''"
                                @click="activeTab = tab.id"
                                x-html="tab.title + notifications"></li>
                        </template>
                    </ul>

                </div>
                <div class="mt-0">
                    <div class="mx-auto">
                        <livewire:social::post-editor/>

                        <h1 class="sr-only">Recent Posts</h1>
                        <div class="mt-6 space-y-4">
                            @if ($recentlyAddedPost)
                                <x-social::post.card wire:key="post-{{ $post->id }}" :post="$post"/>
                            @endif
                            @foreach ($this->posts as $post)
                                <x-social::post.card wire:key="post-{{ $post->id }}" :post="$post"/>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <!-- Featured Section -->
                    <livewire:social::map/>

                    <!-- Posts -->
                    <ul role="list" class="mt-6 space-y-4">
                        @foreach ($activities as $activity)
                            <livewire:social::partials.activity-list-item :activity="$activity"/>
                        @endforeach
                    </ul>
                </div>
            </div>
            <x-sidebar-column/>
        </div>
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
                        title: 'My Feed',
                        component: 'social.posts'
                    },
                    {
                        id: 1,
                        title: 'Top Projects',
                        component: 'social.top-projects'
                    },
                    {
                        id: 2,
                        title: 'Newest',
                        component: 'social.newest'
                    },
                    {
                        id: 3,
                        title: 'Favorites',
                        component: 'social.favorites'
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
