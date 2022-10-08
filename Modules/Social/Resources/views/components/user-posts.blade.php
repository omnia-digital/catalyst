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
                <select x-model="activeTab" class="block w-full rounded-md border-neutral-light py-2 pl-3 pr-10 text-base focus:border-secondary focus:outline-none focus:ring-secondary sm:text-sm">
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
                            class="mr-4 last:mr-0 cursor-pointer hover:text-secondary hover:border-secondary focus:text-secondary focus:border-secondary whitespace-nowrap py-4 px-1 border-b-2 font-semibold"
                            :class="(activeTab === index) ? 'border-secondary text-secondary' : 'border-transparent text-light-text-color'"
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
            @foreach ($posts as $post)
                <livewire:social::components.post-card-dynamic :post="$post"/>
            @endforeach
        </div>
    </div>
</div>
