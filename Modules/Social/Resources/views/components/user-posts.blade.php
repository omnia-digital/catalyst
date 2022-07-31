<div>
    <!-- Posts Nav -->
    <div>
        <div class="sm:hidden">
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
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex text-lg font-bold text-neutral-dark" aria-label="Tabs">
                    <a href="#" class="border-transparent hover:text-secondary text-secondary border-b-secondary hover:border-b-secondary whitespace-nowrap flex pb-4 pl-1 pr-4
                            border-b-2">
                        Posts
                        @if(false)
                            <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">6</span>
                        @endif
                    </a>

                    <a href="#" class="border-transparent hover:text-secondary hover:border-b-secondary whitespace-nowrap flex pb-4 pl-1 pr-4 border-b-2">
                        Likes

                        @if(false)
                            <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">6</span>
                        @endif
                    </a>

                    <a href="#" class="border-transparent hover:text-secondary  hover:border-b-secondary whitespace-nowrap flex pb-4 pl-1 pr-4 border-b-2">
                        Resources

                        @if(false)
                            <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">6</span>
                        @endif                            </a>
                </nav>
            </div>
        </div>
    </div>
    <!-- Posts -->
    <div>
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
