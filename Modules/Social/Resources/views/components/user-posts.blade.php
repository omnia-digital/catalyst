<div
    x-data="{
        activeTab: 0,
        tabs: ['Posts'{{-- , 'Likes', 'Resources' --}}]   
    }" 
>
    <!-- Posts Nav -->
    <div>
        {{-- <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
            <select id="tabs" name="tabs" class="block w-full pl-3 pr-10 pb-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm
                    rounded-md">
                <option>Applied</option>

                <option>Phone Screening</option>

                <option selected>Interview</option>

                <option>Offer</option>

                <option>Disqualified</option>
            </select>
        </div> --}}
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="flex items-center text-xs">
                    <ul class="flex font-semibold border-b-2 border-gray-300 w-full pb-3">
                        <template x-for="(tab, index) in tabs" :key="index" class="space-x-4">
                            <li class="mr-4 last:mr-0 pb-[3px]">
                                <a type="button"
                                   class="text-base-text-color cursor-pointer transition duration-150 ease-in border-b-2 border-transparent pb-4 hover:text-secondary focus:text-secondary hover:border-secondary focus:border-secondary"
                                   :class="(activeTab === index) && 'border-secondary text-secondary'"
                                   x-on:click.prevent="activeTab = index;"
                                   x-text="tab"
                                ></a>
                            </li>
                        </template>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <!-- Posts -->
    <div x-show="activeTab === 0">
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
