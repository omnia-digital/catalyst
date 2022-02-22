<div>
@extends('social::livewire.layouts.social-app')

@section('content')
<div>
    <!-- Page Heading -->
    <div class="xl:grid xl:grid-cols-9 xl:gap-9">
        <div class="xl:col-span-6">
{{--            <div>--}}
{{--                <div class="sm:hidden">--}}
{{--                    <label for="question-tabs" class="sr-only">Select a tab</label>--}}
{{--                    <select id="question-tabs" class="block w-full rounded-md border-gray-300 text-base font-medium text-gray-900 shadow-sm focus:border-rose-500 focus:ring-rose-500">--}}
{{--                        @foreach ($tabs as $tab)--}}
{{--                            <option :selected="$tab['current']">{{ $tab['name'] }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--                <div class="hidden sm:block">--}}
{{--                    <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200" aria-label="Tabs">--}}
{{--                        @foreach($tabs as $tab)--}}
{{--                            <x-sort-button key="created_at" :orderBy="$orderBy">--}}
{{--                                {{ $tab['name'] }}--}}
{{--                            </x-sort-button>--}}
{{--                        @endforeach--}}
{{--                    </nav>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div x-data="
            {
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
                notifications: '<span class=\'ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full\'>3</span>',
            }
            ">
                <ul class="flex justify-center items-center my-4">
                    <template x-for="(tab, index) in tabs" :key="tab.id">
                        <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"
                            :class="activeTab===tab.id ? 'text-black font-bold border-black' : ''" 
                            @click="activeTab = tab.id"
                            x-html="tab.title + notifications"></li>
                    </template>
                </ul>

                <div class="mx-auto">
                    <template x-for="(tab, index) in tabs" :key="tab.id">
                        <div x-show="activeTab === tab.id">
                            <p x-text="tab.title"></p>
                            <livewire:social::new-post-box class="my-6" :user="auth()->user()" />
                            <h1 class="sr-only">Recent Posts</h1>
                            <ul role="list" class="mt-6 space-y-4">
                                @foreach ($this->posts as $post)
                                    <li>
                                        <livewire:social::post-list-item :post="$post" :wire:key="$post->id" />
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </template>
                </div>
            </div>
            
            <div class="mt-4">
                <ul role="list" class="mt-6 space-y-4">
                @foreach ($activities as $activity)
                    <livewire:social::partials.activity-list-item :activity="$activity" />
                @endforeach
                </ul>
            </div>
            <div class="mt-4">
                <livewire:social::map />
            </div>
        </div>
        <aside class="hidden xl:block xl:col-span-3">
            <div class="sticky top-4 space-y-4">
                <livewire:social::partials.trending-section/>
                <livewire:social::partials.who-to-follow-section/>
            </div>
        </aside>
    </div>
</div>
@endsection
</div>
