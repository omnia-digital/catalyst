<nav {{ $attributes->merge(['class' => 'flex relative rounded-b']) }} x-data>
    <div class="flex-1 justify-between items-center w-full ml-32 relative z-10">
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
                    <a href="#" x-data @click.prevent.stop="$openModal('notify-team-modal')" title="Send a message to the entire community">{{ \Trans::get('Notify Team') }}</a>
                    <a href="{{ route('social.teams.admin', $team) }}" class="md:hidden hover:bg-neutral block w-full px-4 py-2 text-left text-sm">{{ \Trans::get('Admin Panel') }}</a>
                @endcan
            </x-library::dropdown>
        </div>
    </div>
    <div class="flex-1 flex pr-2 items-center justify-end">
        @can('update-team', $team)

            <a x-show="$wire.applicationsCount > 0" class="flex items-center hover:underline" :href="route('social:team.admin')">
                <p>{{ Trans::get('Pending Applications: ') }}</p>
                <span x-text="$wire.applicationsCount" class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white-text-color bg-secondary rounded-full hover:no-underline"></span>
            </a>

            <a 
                href="#" 
                x-data 
                @click.prevent.stop="$openModal('notify-team-modal')" 
                title="Send a message to the entire community"
                class="py-4 mx-[10px] hidden md:flex items-center"
            >{{ \Trans::get('Notify Team') }}</a>
            <a href="{{ route('social.teams.admin', $team) }}" class="bg-neutral rounded-lg px-4 py-2 border border-secondary hidden md:block font-bold hover:underline mx-4
            whitespace-nowrap">{{
            \Trans::get('Admin Panel')
            }}</a>
        @endcan

        @if(\App\Support\Platform\Platform::isUsingTeamMemberSubscriptions())
            <div>
                @if(!auth()->user()->subscribed("team_$team->id"))
                    <x-library::button x-data="" x-on:click.prevent="$openModal('subscribe-team')" wire:target="">
                        Subscribe
                    </x-library::button>
                @else
                    <x-library::button x-data="" x-on:click.prevent="$openModal('update-team-plan')" wire:target="">
                        Manage Subscriptions
                    </x-library::button>
                @endif
            </div>
        @endif

        <x-teams.apply-button :team="$team"/>
        {{-- Lists functionality not currently setup
        <div class="inline-flex items-center text-md">
            <button class="p-2 mx-[15px] inline-flex items-center text-sm rounded-full bg-primary"><x-heroicon-s-plus class="h-4 w-4" /></button>
        </div> --}}
    </div>

    <div>
        @auth
            <livewire:teams.subscribe-team-modal :team="$team"/>
            <livewire:teams.update-team-plan-modal :team="$team"/>
            @can('update-team', $team)
                <x-library::modal id="notify-team-modal" maxWidth="4xl">
                    <x-slot:title>
                        {{ \Trans::get('Send a message to the team') }}
                    </x-slot:title>
                    <x-slot:content>
                        <x-library::input.textarea></x-library::input.textarea>
                    </x-slot:content>
                    <x-slot:actions>
                        <x-library::button wire:click.prevent="sendNotification" wire:target="sendNotification">
                            Send
                        </x-library::button>
                    </x-slot:actions>
                </x-library::modal>
            @endcan
        @endauth
    </div>

    <livewire:login-modal/>
</nav>
