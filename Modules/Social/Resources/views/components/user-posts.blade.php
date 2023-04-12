@props([
    'posts' => [],
    'likes' => [],
    'resources' => [],
])
<div
    x-data="{
        activeTab: 'posts',
        tabs: {
            'posts': 'Posts',
            'likes': 'Likes',
            'resources': 'Resources'
        }
    }"
>
    <!-- Posts Nav -->
    <div>
        <div>
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select x-model="activeTab" class="block w-full rounded-md border-neutral-light py-2 pl-3 pr-10 text-base focus:border-primary focus:outline-none focus:ring-primary sm:text-sm">
                    <template x-for="(tab, index) in tabs" :key="index" class="space-x-4">
                        <option :value="index" x-text="tab"></option>
                    </template>
                </select>
              </div>
              <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                  <nav class="-mb-px flex" aria-label="Tabs">
                    <template x-for="(tab, index) in tabs" :key="index">
                        <a type="button"
                            class="mr-4 last:mr-0 cursor-pointer hover:text-primary hover:border-primary focus:text-primary focus:border-primary whitespace-nowrap py-4 px-1 border-b-2 font-semibold"
                            :class="(activeTab === index) ? 'border-primary text-primary' : 'border-transparent text-light-text-color'"
                            x-on:click.prevent="activeTab = index;"
                            x-text="tab"
                        ></a>
                    </template>
                  </nav>
                </div>
              </div>
        </div>
    </div>
    <!-- Posts -->
    <div x-show="activeTab === 'posts'">
        {{--                <div class="flex justify-between items-center text-base-text-color font-semibold">--}}
        {{--                    <p class="text-sm flex">Posts <span class="bg-gray-400 rounded-full ml-2 w-5 h-5 flex justify-center items-center">{{ $this->user->posts()->count() }}</span></p>--}}
        {{--                    <a href="#" class="text-xs flex items-center">See all--}}
        {{--                        <x-heroicon-s-chevron-right class="ml-2 w-4 h-4"/>--}}
        {{--                    </a>--}}
        {{--                </div>--}}
        <div class="mt-4 space-y-4">
            @forelse ($posts as $post)
                <livewire:social::components.post-card-dynamic :post="$post" />
            @empty
                <div class="bg-white p-4">
                    <p class="text-dark-text-color">{{ \Trans::get('No posts to show.') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <div x-cloak x-show="activeTab === 'likes'">
        <div class="mt-4 space-y-4">
            @forelse ($likes as $like)
                <div class="bg-white p-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ $like->likable?->user?->profile_photo_url }}" alt="{{ $like->likable?->user?->name }}"/>
                        </div>
                        <p class="text-dark-text-color">
                            <strong>{{ $this->user?->name }}</strong> liked <strong>{{ $like->likable?->user?->name }}</strong>'s {{ \Trans::get(strtolower(class_basename($like->likable::class))) }}</p>
                    </div>
                </div>
            @empty
                <div class="bg-white p-4">
                    <p class="text-dark-text-color">{{ \Trans::get('No likes to show. Check back later!') }}</p>
                </div>
            @endforelse
        </div>
    </div>

    <div x-cloak x-show="activeTab === 'resources'">
        <div class="mt-4 space-y-4">
            @forelse ($resources as $resource)
                <livewire:social::components.post-card-dynamic :post="$resource" />
            @empty
                <div class="bg-white p-4">
                    <p class="text-dark-text-color">{{ \Trans::get('No resources to show. Check back later!') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
