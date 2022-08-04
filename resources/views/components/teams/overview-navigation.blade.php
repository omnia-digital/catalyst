<nav {{ $attributes->merge(['class' => 'flex relative rounded-b']) }}>
    <div class="flex justify-between items-center w-full ml-32 relative z-10">
        <div class="flex">
            @foreach ($nav as $key => $item)
                <a
                    href="{{ route('social.teams.' . $key, $team) }}"
                    class="py-4 mx-[10px] flex items-center border-b-2 border-b-transparent {{ $pageView === $key ? 'border-b-secondary' : '' }} hover:border-b-secondary">
                    {{ $item }}
                    @if ($key === 'members')
                        <span class="ml-2 px-2 py-1 flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $team->users()->count() }}</span>
                    @endif
                    @if ($key === 'followers')
                        <span class="ml-2 px-2 py-1 flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $team->followers()->count() }}</span>
                    @endif
                </a>
            @endforeach
           {{-- No items for dropdown at this time
            <x-library::dropdown>
                <x-slot name="trigger">
                    <button type="button" class="py-4 mx-4 flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                    </button>
                </x-slot>
                <x-library::dropdown.item>
                    Some dropdown item
                </x-library::dropdown.item>
            </x-library::dropdown> --}}
        </div>
    </div>
    <div class="flex pr-2 items-center">
        @can('update-team', $team)
            <a href="{{ route('social.teams.edit', $team) }}" class="py-4 mx-4 whitespace-nowrap">{{ \Trans::get('Edit Team') }}</a>
        @endcan
        <livewire:social::partials.follow-button :model="$team" class="py-4 mx-4"/>
        <div class="inline-flex items-center text-md relative">
            <div class="absolute inset-auto -translate-y-12 p-2 rounded-md bg-black text-white-text-color"
                x-data="{show: false}"
                x-show="show"
                x-transition:enter-start="opacity-0 translate-y-0"
                x-transition:enter-end="opacity-100 -translate-y-12"
                x-transition:leave.opacity.duration.1500ms
                x-init="@this.on('applied', () => {
                    show = true;
                    setTimeout(() => { show = false; }, 3000);
                })"
                style="display: none;"
            >
                <span>{{ \Trans::get('Application Submitted') }}</span>
            </div>
            <div class="absolute inset-auto -translate-y-12 rounded-md p-2 bg-black text-white-text-color"
                x-data="{show: false}"
                x-show="show"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-0"
                x-transition:enter-end="opacity-100 -translate-y-12"
                x-transition:leave.opacity.duration.1500ms
                x-init="@this.on('application_removed', () => {
                    show = true;
                    setTimeout(() => { show = false; }, 3000);
                })"
                style="display: none;"
            >
                <span>{{ \Trans::get('Application Removed') }}</span>
            </div>
            @if ($team->teamApplications()->hasUser(auth()->id()))
                <button
                    class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-primary whitespace-nowrap"
                    wire:click="removeApplication"
                >{{ \Trans::get('Remove Application') }}</button>
            @elseif(!$team->hasUser(auth()->user()))
                <div class="absolute -top-9 right-0 w-96">
                    <x-jet-input-error for="user_id" class="mt-2" />
                </div>
                <button
                    class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-secondary text-white-text-color"
                    wire:click="applyToTeam"
                >{{ \Trans::get('Apply') }}</button>
            @endif
        </div>
        {{-- Lists functionality not currently setup
        <div class="inline-flex items-center text-md">
            <button class="p-2 mx-[15px] inline-flex items-center text-sm rounded-full bg-primary"><x-heroicon-s-plus class="h-4 w-4" /></button>
        </div> --}}
    </div>
</nav>
