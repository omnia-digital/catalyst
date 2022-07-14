<div class="h-full min-w-[295px] p-2 {{ $classes }}">
    <div x-data="{
            showDetail: false,
            message: '',
            title: null,
            details: {
                name: null, 
                start_date_string: null, 
                users_count: null, 
                summary: null, 
                location_short: null
            },
            selectEvent(event) {
                this.showDetail = true;
                $dispatch('select_event', event.id);
                $wire.selectTeam(event.id)

                this.populateData(event);
            },

            populateData(data) {
                this.title = data.name;
                for (var key in this.details) {
                    this.details[key] = data[key];
                };
            },
        }" 
        x-init="
            @this.on('select_event', (eventID) => {
                showDetail = true;
            });
            @this.on('applied_to_team', () => {
                message = '{{ \Trans::get('Application Submitted') }}';
                setTimeout(() => { message = false; }, 3000);
            });
            @this.on('application_removed', () => {
                message = '{{ \Trans::get('Application Removed') }}';
                setTimeout(() => { message = false; }, 3000);
            });
        "
        class="flex flex-col sticky h-full top-20 inset-y-2">
        <div class="h-full flex flex-col">
            <div class="bg-primary flex justify-between items-center text-xl min-h-[64px] pt-2 px-4">
                <div class="font-medium">
                    <div class="text-xl" x-show="!showDetail">{{ \Trans::get('Teams') }}</div>
                    <div x-show="showDetail" class="text-lg font-bold" x-text="title"></div>
                </div>
                <div class="flex items-center space-x-4">
                        <a x-show="!showDetail" href="{{ route('social.teams.map') }}" @class([
		                    'text-light-text-color hover:text-secondary active:text-secondary focus:text-secondary',
		                    'text-secondary' => request()->routeIs('social.teams.map')
                            ])>
                            <span class="sr-only" x-text="'Map'"></span>
                            <span><x-heroicon-o-map class="h-6 w-6" /></span>
                        </a>
                        <a x-show="!showDetail" href="{{ route('social.teams.calendar') }}" @class([
		                    'text-light-text-color hover:text-secondary active:text-secondary focus:text-secondary',
		                    'text-secondary' => request()->routeIs('social.teams.calendar')
                            ])>
                            <span class="sr-only" x-text="'Calendar'"></span>
                            <span><x-heroicon-o-calendar class="h-6 w-6" /></span>
                        </a>
                        <a x-cloak x-show="showDetail" href="#" 
                            x-on:click.prevent="showDetail = false"
                            @class([
		                    'text-light-text-color hover:text-secondary active:text-secondary focus:text-secondary'
                            ])>
                            <span class="sr-only" x-text="'Close Details'"></span>
                            <span><x-heroicon-o-x class="h-6 w-6" /></span>
                        </a>
                </div>
            </div>
            
            <!-- Filters -->
            <div x-show="!showDetail">
                @include('livewire.partials.filters-sm', ['skipFilters' => ['has_attachment' => true]])
            </div>

            <!-- Show All Teams -->
            <div x-show="!showDetail" class="bg-primary space-y-2 pt-4 pb-2 flex-1 overflow-y-scroll scrollbar-hide">
                @forelse ($teams as $item)
                    <div
                        class="space-y-2 mx-2 p-4 bg-primary rounded-lg border border-neutral cursor-pointer
                            {{ (!is_null($team) && ($team->handle === $item->handle)) ? 'shadow-md ring-1 ring-neutral-dark' : '' }}
                            hover:shadow-lg  hover:ring-2 hover:ring-neutral-dark active:shadow-lg active:ring-2 active:ring-neutral-dark focus:shadow-lg focus:ring-2 focus:ring-neutral-dark"
                        {{-- wire:click="selectEvent({{ $item->id }})" --}}
                        x-on:click="selectEvent({{ $item }})"
                    >
                        <div class="flex justify-between">
                            <p class="text-dark-text-color font-semibold text-base">{{ $item->name }}</p>

                        </div>
                        <div class="flex items-center text-base-text-color">
                            @isset($item->location)
                                <x-heroicon-o-location-marker class="h-4 w-4 mr-2" />
                                <span class="text-dark-text-color text-xs">{{ $item->location }}</span>
                            @endisset
                        </div>
                        <p class="text-light-text-color text-xs line-clamp-3">{{ $item->summary }}</p>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <x-heroicon-o-users class="h-4 w-4 mr-2" />
                                <p>{{ $item->users_count }}</p>
                            </div>
                            <div class="flex items-center">
                                <x-heroicon-o-calendar class="h-4 w-4 mr-2" />
                                <p>{{ $item->start_date?->toFormattedDateString() }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div>No {{ \Trans::get('teams') }} to show</div>
                @endforelse
            </div>

            <!-- Show Team Details -->
            <div x-cloak x-show="showDetail" class="bg-primary space-y-2 pt-4 pb-24 flex-1 overflow-y-scroll scrollbar-hide">
                <div class="px-4 space-y-2">
                    <div x-show="details.start_date_string" class="flex items-center space-x-2">
                        <x-heroicon-o-calendar class="w-4 h-4" />
                        <span class="flex-1 text-sm" x-text="details.start_date_string"></span>
                    </div>
                    <div x-show="details.location_short" class="flex items-center space-x-2">
                        <x-heroicon-o-location-marker class="w-4 h-4" />
                        <span class="flex-1 text-sm" x-text="details.location_short"></span>
                    </div>
                    <div class="flex items-center space-x-2 ">
                        <x-heroicon-o-users class="w-4 h-4" />
                        <span class="flex-1 text-sm" x-text="details.users_count"></span>
                    </div>
                    <div class="text-sm pt-2" x-text="details.summary"></div>
                </div>
                <div class="absolute bottom-0 left-0 right-0 p-6 flex items-center justify-center bg-primary">
                    <div wire:loading wire:target="selectTeam" class="absolute inset-0 bg-white/75"></div>
                    <div class="absolute inset-auto -translate-y-12 rounded-md p-2 text-success-700"
                        x-show="message"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-0"
                        x-transition:enter-end="opacity-100 -translate-y-12"
                        x-transition:leave.opacity.duration.1500ms
                        x-cloak
                    >
                        <span x-text="message"></span>
                    </div>
                    <button
                        wire:click.prevent="moreInfo"
                        class="py-2 px-4 mx-2 flex-1 flex justify-center items-center text-sm rounded-md bg-transparent border-2 border-secondary text-secondary hover:bg-neutral-light active:bg-neutral-light focus:bg-neutral-light"
                    >More Info</button>
                    @if (!is_null($team) && $team->teamApplications()->hasUser($this->user->id))
                        <button
                            class="py-2 px-4 mx-2 flex-1 flex justify-center items-center text-sm rounded-md bg-secondary border-2 border-secondary text-white hover:opacity-75 active:opacity-75 focus:opacity-75"
                            wire:click="removeApplication"
                        >{{ \Trans::get('Remove Application') }}</button>
                    @elseif(!is_null($team) && !$team->hasUser($this->user))
                        <div class="absolute -top-9 right-0 w-96">
                            <x-jet-input-error for="user_id" class="mt-2" />
                        </div>
                        <button
                            class="py-2 px-4 mx-2 flex-1 flex justify-center items-center text-sm rounded-md bg-secondary border-2 border-secondary text-white hover:opacity-75 active:opacity-75 focus:opacity-75"
                            wire:click="applyToTeam"
                        >{{ \Trans::get('Apply') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>

    </script>
@endpush