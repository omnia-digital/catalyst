<div>
    <!-- Page Heading -->
    <div class="xl:grid xl:grid-cols-9 xl:gap-9">
        <div class="xl:col-span-6">
            <div>
                <ul class="flex justify-center items-center my-4">
                    {{-- <template x-for="tab in tabs">
                        <li>asdf</li>
                        <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-gray-500 border-b-2 justify-center"
                            :class="activeTab===tab.id ? 'text-black font-bold border-black' : ''" 
                            @click="activeTab = tab.id"
                            x-html="tab.title + notifications"></li>
                    </template> --}}
                </ul>

                <div class="mx-auto">
                    <livewire:social::new-post-box class="my-6" />
                    <h1 class="sr-only">Recent Posts</h1>
                    <ul role="list" class="mt-6 space-y-4">
                        @if ($recentlyAddedPost)
                            <li>
                                <livewire:social::post-list-item :post="$recentlyAddedPost" :wire:key="$recentlyAddedPost->id" />
                            </li>
                        @endif
                        @foreach ($this->posts as $post)
                            <li>
                                <livewire:social::post-list-item :post="$post" :wire:key="$post->id" />
                            </li>
                        @endforeach
                    </ul>

                    {{-- <template x-for="tab in tabs" :key="tab.id">
                        <div x-show="activeTab === tab.id">
                            <p x-text="tab.title"></p>
                        </div>
                    </template> --}}
                </div>
            </div>
            
            {{-- <div class="mt-4">
                <ul role="list" class="mt-6 space-y-4">
                @foreach ($activities as $key => $activity)
                    <livewire:social::partials.activity-list-item :activity="$activity" :wire:key="$key" />
                @endforeach
                </ul>
            </div> --}}
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
    @push('scripts')
        <script>
            function setup() {
                return {
                    activeTab: 0,
                    tabs: [
                        {
                            id: 0,
                            title: 'My Feed',
                        },
                        {
                            id: 1,
                            title: 'Top Projects',
                        },
                        {
                            id: 2,
                            title: 'Newest',
                        },
                        {
                            id: 3,
                            title: 'Favorites',
                        },
                        {
                            id: 4,
                            title: 'Undiscovered',
                        },
                    ],
                    notifications: '<span class=\'ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full\'>3</span>',
                }
            }
        </script>
    @endpush
</div>
