<nav {{ $attributes->merge(['class' => 'flex relative rounded-b']) }}>
    <div class="flex justify-between items-center w-full ml-32 relative z-10">
        <div class="flex">
            @foreach ($nav as $key => $item)
                <a
                    href="{{ route('social.profile.' . $key, $user->handle) }}"
                    class="py-4 pl-2 pr-6 flex border-b-2 border-b-transparent {{ $pageView === $key ? 'border-b-secondary' : '' }} hover:border-b-secondary">
                    {{ $item }}
                    @if ($key === 'followers')
                        <span class="ml-2 px-1 w-[21px] h-[22px] flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $user->followers()->count() }}</span>
                    @endif
                </a>
            @endforeach
            {{-- <x-library::dropdown>
                <x-slot name="trigger">
                    <button type="button" class="py-4 mx-4 flex items-center text-light-text-color hover:text-base-text-color" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                    </button>
                </x-slot>
                <x-library::dropdown.item>
                    Invite to "{{ auth()->user()->currentTeam->name }}"
                </x-library::dropdown.item>
            </x-library::dropdown> --}}
        </div>
    </div>
    <div class="flex pr-2 items-center">
        @can('update-profile', $user->profile)
            <a href="{{ route('social.profile.edit', $user->handle) }}" class="py-4 mx-4 whitespace-nowrap">{{ \Trans::get('Edit Profile') }}</a>
            <a href="{{ route('billing.billing') }}" class="py-4 mx-4 whitespace-nowrap">{{ \Trans::get('Billing') }}</a>
        @endcan
        <livewire:social::partials.follow-button :model="$user" class="py-4 mx-4"/>
        {{-- Lists functionality not currently setup
        <div class="inline-flex items-center text-md">
            <button class="p-2 mx-[15px] inline-flex items-center text-sm rounded-full bg-primary"><x-heroicon-s-plus class="h-4 w-4" /></button>
        </div> --}}
    </div>
</nav>
