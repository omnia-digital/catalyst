<nav
        {{ $attributes->merge(['class' => 'bg-white shadow']) }}
        x-data="{ open: false }"
>
    <div class="mx-auto px-4 sm:px-6">
        <div class="md:ml-28 relative flex h-16 justify-between">
            <div class="flex">
                <div class="hidden sm:flex sm:space-x-8">
                    @foreach ($nav as $key => $item)
                        <a
                                href="{{ route('social.profile.' . $key, $user->handle) }}"
                                class="inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium {{ $pageView === $key ? 'border-primary text-base-text-color' : 'border-transparent text-light-text-color hover:border-primary hover:text-tertiary' }}">
                            {{ $item }}
                            @if ($key === 'followers')
                                <span class="ml-2 px-1 w-[21px] h-[22px] flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $user->followers()->count() }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
                <div class="sm:hidden flex items-center">
                    <livewire:catalyst::partials.follow-button :model="$user"/>
                </div>
            </div>
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @can('update-profile', $user->profile)
                    <a href="{{ route('social.profile.edit', $user->handle) }}"
                       class="py-4 mx-4 whitespace-nowrap">{{ Translate::get('Edit Profile') }}</a>
                @endcan
                <livewire:catalyst::partials.follow-button :model="$user" class="py-4 mx-4"/>
            </div>
            <div class="-mr-2 flex items-center sm:hidden">
                <!-- Mobile menu button -->
                <button type="button" x-on:click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-light-text-color hover:bg-neutral-light hover:text-light-text-color focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary"
                        aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <x-library::icons.icon name="fa-light fa-bars" x-show="!open" class="h-6 w-6"/>
                    <x-library::icons.icon name="x-mark" x-cloak x-show="open" class="h-6 w-6"/>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div
            class="sm:hidden" id="mobile-menu"
            x-cloak
            x-show="open"
            x-collapse
    >
        <div class="space-y-1 pt-2 pb-3">
            @foreach ($nav as $key => $item)
                <a
                        href="{{ route('social.profile.' . $key, $user->handle) }}"
                        class="flex items-center border-l-4 py-2 pl-3 pr-4 text-base font-medium {{ $pageView === $key ? 'border-primary bg-neutral text-primary' : 'border-transparent text-neutral-dark hover:border-neutral-dark hover:bg-neutral-hover hover:text-dark-text-color' }}">
                    {{ $item }}
                    @if ($key === 'followers')
                        <span class="ml-2 px-1 w-[21px] h-[22px] flex justify-center items-center rounded-full bg-neutral-dark text-white-text-color text-xs font-semibold">{{ $user->followers()->count() }}</span>
                    @endif
                </a>
            @endforeach
        </div>
        @can('update-profile', $user->profile)
            <div class="border-t border-gray-200 pt-4 pb-3">
                <div class="space-y-1">
                    <a href="{{ route('social.profile.edit', $user->handle) }}"
                       class="block px-4 py-2 text-base font-medium text-light-text-color hover:bg-neutral-hover hover:text-dark-text-color whitespace-nowrap">{{ Translate::get('Edit Profile') }}</a>
                </div>
            </div>
        @endcan
    </div>
</nav>
