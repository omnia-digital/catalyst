<nav {{ $attributes->merge(['class' => 'flex relative rounded-b']) }} x-data>
    <div class="flex justify-between items-center w-full ml-32 relative z-10">
        <div class="flex ml-auto md:ml-0">
            @foreach ($nav as $key => $item)
                <a
                        href="{{ route('social.teams.' . $key, $team) }}"
                        class="py-4 mx-[10px] hidden md:flex items-center border-b-2 border-b-transparent {{ $pageView === $key ? 'border-b-secondary' : '' }} hover:border-b-secondary">
                    {{ $item }}
                    @if ($key === 'members')
                        <span class="ml-2 px-2 py-1 flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $team->users()->count() }}</span>
                    @endif
                    @if ($key === 'followers')
                        <span class="ml-2 px-2 py-1 flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $team->followers()->count() }}</span>
                    @endif
                </a>
            @endforeach
            <x-library::dropdown dropdownClasses="bg-primary divide-primary border-0">
                <x-slot name="trigger">
                    <button type="button" class="md:hidden py-4 mx-4 flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <x-heroicon-s-dots-vertical class="h-6 w-6"/>
                    </button>
                </x-slot>
                @foreach ($nav as $key => $item)
                    <a
                            href="{{ route('social.teams.' . $key, $team) }}"
                            class="md:hidden block w-full px-4 py-2 text-left text-sm disabled:text-base-text-color border-transparent bg-primary {{ $pageView === $key ? 'bg-neutral text-secondary' : '' }} hover:bg-neutral">
                        {{ $item }}
                        @if ($key === 'members')
                            <span class="ml-2 px-2 py-1 rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $team->users()->count() }}</span>
                        @endif
                        @if ($key === 'followers')
                            <span class="ml-2 px-2 py-1 rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $team->followers()->count() }}</span>
                        @endif
                    </a>
                @endforeach
                @can('update-team', $team)
                    <a href="{{ route('social.teams.edit', $team) }}" class="md:hidden hover:bg-neutral block w-full px-4 py-2 text-left text-sm">{{ \Trans::get('Admin Panel') }}</a>
                @endcan
            </x-library::dropdown>
        </div>
    </div>
    <div class="flex pr-2 items-center">
        @can('update-team', $team)
            <a href="{{ route('social.teams.edit', $team) }}" class="bg-neutral rounded-lg px-4 py-2 border border-secondary hidden md:block font-bold hover:underline mx-4
            whitespace-nowrap">{{
            \Trans::get('Admin Panel')
            }}</a>
        @endcan

        <livewire:social::partials.follow-button :model="$team" class="py-4 mx-4"/>

        @if ($team->hasStripeConnectAccount())
            <div>
                @if(!auth()->user()->subscribed("team_$team->id"))
                    <x-library::button x-data="" x-on:click.prevent="$openModal('subscribe-team')" wire:target="">
                        Subscribe
                    </x-library::button>
                @else
                    <x-library::button x-data="" x-on:click.prevent="$openModal('update-team-plan')" wire:target="">
                        Manage Subscription
                    </x-library::button>
                @endif
            </div>
        @endif

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
                        class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-primary whitespace-nowrap hover:opacity-75"
                        wire:click="removeApplication"
                >{{ \Trans::get('Remove Application') }}</button>
            @elseif(!$team->hasUser(auth()->user()))
                <div class="absolute -top-9 right-0 w-96">
                    <x-jet-input-error for="user_id" class="mt-2"/>
                </div>
                <button
                        class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-secondary text-white-text-color hover:opacity-75"
                        wire:click="applyToTeam"
                >{{ \Trans::get('Apply') }}</button>
            @endif
        </div>
        {{-- Lists functionality not currently setup
        <div class="inline-flex items-center text-md">
            <button class="p-2 mx-[15px] inline-flex items-center text-sm rounded-full bg-primary"><x-heroicon-s-plus class="h-4 w-4" /></button>
        </div> --}}
    </div>

    <livewire:teams.subscribe-team-modal :team="$team"/>
    <livewire:teams.update-team-plan-modal :team="$team"/>
</nav>
