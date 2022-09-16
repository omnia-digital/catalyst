<div class="card">
    <div class="py-3 flex-1 space-y-1 overflow-y-auto">
        <div class="pl-4 flex justify-between items-center">
            <x-library::heading.2 class="text-xl font-medium text-gray-900">
                {{ Trans::get('Teams') }}
            </x-library::heading.2>
            <div x-data="{show: false, message: ''}"
                x-cloak
                x-show="show"
                x-transition:leave.opacity.duration.1500ms
                x-init="@this.on('team_action', (eventMessage) => {
                    message = eventMessage;
                    show = true;
                    setTimeout(() => { show = false; }, 3000);
                })"
            >
                <p class="text-sm text-green-600" x-text="message"></p>
            </div>
        </div>
        <div
            x-data="{
                activeTab: 0,
                tabs: [
                    {
                        label: '{{ \Trans::get('Invitations') }}',
                        count: {{ $invitations->count() }}
                    },
                    {
                        label: '{{ \Trans::get('Requests') }}',
                        count: {{ $applications->count() }}
                    }
                ]
            }"
            x-init="@this.on('team_action', (eventMessage) => {
                tabs[0].count = $wire.invitationsCount();
                tabs[1].count = $wire.applicationsCount();
            })"
        >
            <ul class="flex justify-center items-center my-4">
                <template x-for="(tab, index) in tabs" :key="index">
                    <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-base-text-color border-b-2 justify-center"
                        :class="activeTab===index ? 'text-base-text-color font-bold border-black' : ''" @click="activeTab = index"
                    >
                        <span x-text="tab.label"></span>
                        <template x-if="tab.count > 0">
                            <span x-text="tab.count" class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white-text-color bg-black rounded-full"></span>
                        </template>
                    </li>
                </template>
            </ul>

            <div class="bg-primary mx-auto">
                <div x-show="activeTab===0">
                    <div class="flex justify-between">
                        <div class="px-6 flex flex-col divide-y space-y-3">
                            @forelse ($invitations as $invitation)
                                <div class="py-3 space-y-4">
                                    <div class="flex items-center">
                                        <div class="mr-3 w-10 h-10 rounded-full">
                                            <img class="w-full h-full overflow-hidden object-cover object-center rounded-full" src="{{ $invitation->user?->profile_photo_url }}" alt="{{ $invitation->user->name }}" />
                                        </div>
                                        <div class="flex-1">
                                            <x-library::heading.3 class="mb-2 sm:mb-1 text-dark-text-color text-sm font-normal leading-5"><span class="font-bold">{{ $invitation->inviter->name }}</span> wants you to join <span class="font-bold">{{ $invitation->team->name }}</span></x-library::heading.3>
                                        </div>
                                    </div>
                                    @if ($invitation->message)
                                        <div>
                                            <p class="test-dark-test-color text-sm line-clamp-3">{{ $invitation->message }}</p>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="flex justify-center divide-x">
                                            <button type="button"
                                                wire:click="addTeamMember({{ $invitation->id }})"
                                                class="flex items-center text-sm px-6 rounded-md font-semibold hover:underline">
                                                <x-heroicon-o-check class="w-4 h-4 mr-2" />
                                                Accept
                                            </button>
                                            <button type="button"
                                                wire:click="cancelTeamInvitation({{ $invitation->id }})"
                                                class="flex items-center text-sm px-6 rounded-md font-semibold hover:underline">
                                                <x-heroicon-o-x class="w-4 h-4 mr-2" />
                                                Decline
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    <p>{{ \Trans::get('There are no pending invitations') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="activeTab===1">
                    <div class="flex justify-between">
                        <div class="px-6 flex flex-col divide-y space-y-3">
                            @forelse ($applications as $application)
                                <div>
                                    <div class="flex items-center">
                                        <div class="mr-3 w-10 h-10 rounded-full">
                                            <img class="w-full h-full overflow-hidden object-cover object-center rounded-full" src="{{ $application->team->owner?->profile_photo_url }}" alt="{{ $application->team->owner?->name }}" />
                                        </div>
                                        <div class="flex-1">
                                            <x-library::heading.3 class="mb-2 sm:mb-1 text-dark-text-color text-sm font-normal leading-5">You applied to join <span class="font-bold">{{ $application->team->name }}</span></x-library::heading.3>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-end divide-x">
                                            <button type="button"
                                                wire:click="removeApplication({{ $application->id }})"
                                                class="flex items-center text-sm px-6 rounded-md text-red-500 font-semibold hover:underline">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div>
                                    <p>{{ \Trans::get('There are no pending applications') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
