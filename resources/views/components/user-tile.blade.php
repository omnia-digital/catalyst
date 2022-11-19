<div {{ $attributes->merge(['class'=> 'bg-secondary border border-neutral-light rounded w-full max-w-sm']) }}>
    <div class="relative">
        <div class="h-24 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
        <div class="absolute -bottom-12 left-5">
            <img class="h-20 w-20 rounded-full border-4 border-white bg-white" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
        </div>
    </div>
    <div class="space-y-2 p-4">
        <div class="flex justify-between">
            <div>
                <a href="{{ $user->url() }}" class="pt-10 block">
                    <p class="text-dark-text-color font-semibold text-xs">{{ $user->name }}</p>
                    <p class="text-light-text-color text-xs">{{ '@' . $user->handle }}</p>
                </a>
            </div>
            <div class="flex justify-end items-center">
                <livewire:social::partials.follow-button :model="$user" :key="'follow-user-' . $user->id" />
                @if ($team)
                    <div>
                        <x-library::dropdown>
                            <x-slot name="trigger">
                                <button type="button" class="pl-2 py-2 flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open options</span>
                                    <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                                </button>
                            </x-slot>
                            <!-- Leave Team -->
                            @if (auth()->id() === $user->id)
                                <x-library::dropdown.item class="cursor-pointer text-sm text-red-500 hover:bg-dark-text-color" wire:click="$toggle('confirmingLeavingTeam')">
                                    {{ \Trans::get('Leave Team') }}
                                </x-library::dropdown.item>

                            <!-- Remove Team Member -->
                            @elseif (Gate::check('removeTeamMember', $team))
                                <x-library::dropdown.item class="cursor-pointer text-sm text-red-500 hover:bg-dark-text-color" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                    {{ \Trans::get('Remove Member') }}
                                </x-library::dropdown.item>
                            @endif
                        </x-library::dropdown>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
