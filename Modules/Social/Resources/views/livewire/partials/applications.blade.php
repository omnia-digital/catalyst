<div class="card">
    <div class="flex-1 p-6 space-y-1 overflow-y-auto">
        <div class="flex justify-between items-center">
            <h3 class="text-base-text-color text-base font-semibold">Projects</h3>
            <div x-data="{show: false, message: ''}"
                x-cloak 
                x-show="show"
                x-transition:leave.opacity.duration.1500ms 
                x-init="@this.on('project_action', (eventMessage) => { 
                    message = eventMessage;
                    show = true; 
                    setTimeout(() => { show = false; }, 3000);
                })"
            >
                <p class="text-sm text-green-600" x-text="message"></p>
            </div>
        </div>
        <div x-data="applicationsSetup">
            <ul class="flex justify-center items-center my-4"> 
                <template x-for="(tab, index) in tabs" :key="index">
                    <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-base-text-color border-b-2 justify-center"
                        :class="activeTab===index ? 'text-black font-bold border-black' : ''" @click="activeTab = index"
                    >
                        <span x-text="tab.label"></span>
                        <template x-if="tab.count > 0">
                            <span x-text="tab.count" class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full"></span>
                        </template>
                    </li>
                </template>
                {{-- <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-base-text-color border-b-2 justify-center"
                    :class="activeTab===0 ? 'text-black font-bold border-black' : ''" @click="activeTab = 0"
                >
                    <span>Invitations</span>
                    @if ($invitations->count() > 0)
                        <span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">{{ $invitations->count() }}</span>
                    @endif
                </li>
                <li class="flex flex-1 text-sm cursor-pointer py-2 px-6 text-base-text-color border-b-2 justify-center"
                    :class="activeTab===1 ? 'text-black font-bold border-black' : ''" @click="activeTab = 1"
                >
                    <span>Requests</span>
                    @if ($applications->count() > 0)
                        <span class="ml-2 text-xs w-5 h-5 flex items-center justify-center text-white bg-black rounded-full">{{ $requests->count() }}</span>
                    @endif
                </li> --}}
            </ul>

            <div class="bg-primary mx-auto">
                <div x-show="activeTab===0">
                    <div class="flex justify-between">
                        <div class="flex flex-col divide-y">
                            @forelse ($invitations as $invitation)
                                <div class="py-3 space-y-3">
                                    <div class="flex items-center">
                                        <div class="mr-3 w-10 h-10 rounded-full">
                                            <img class="w-full h-full overflow-hidden object-cover object-center rounded-full" src="{{ $invitation->user?->profile_photo_url }}" alt="{{ $invitation->user->name }}" />
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="mb-2 sm:mb-1 text-dark-text-color text-sm font-normal leading-5"><span class="font-bold">{{ $invitation->inviter->name }}</span> wants you to join <span class="font-bold">{{ $invitation->team->name }}</span></h3>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="test-dark-test-color text-sm line-clamp-3">{{ $invitation->message }}</p>
                                    </div>
                                    <div>
                                        <div class="flex justify-center divide-x mt-5">
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
                                <div class="py-3">
                                    <p>There are no pending invitations.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div x-cloak x-show="activeTab===1">
                    <div class="flex justify-between">
                        <div class="flex flex-col divide-y">
                            @forelse ($applications as $application)
                                <div class="py-3 space-y-3">
                                    <div class="flex items-center">
                                        <div class="mr-3 w-10 h-10 rounded-full">
                                            <img class="w-full h-full overflow-hidden object-cover object-center rounded-full" src="{{ $application->team->owner?->profile_photo_url }}" alt="{{ $application->team->owner->name }}" />
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="mb-2 sm:mb-1 text-dark-text-color text-sm font-normal leading-5">You applied to join <span class="font-bold">{{ $application->team->name }}</span></h3>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-end divide-x mt-5">
                                            <button type="button" 
                                                wire:click=""
                                                class="flex items-center text-sm px-6 rounded-md text-red-500 font-semibold hover:underline">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-3">
                                    <p>There are no pending applications.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('applicationsSetup', () => ({
            activeTab: 0, 
            tabs: [
                { 
                    label: 'Invitations',
                    count: @js($invitations->count())
                }, 
                {
                    label: 'Requests',
                    count: @js($applications->count())
                }
            ]
        }))
    })
</script>
@endpush
