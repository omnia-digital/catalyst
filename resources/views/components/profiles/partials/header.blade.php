<div>
    <div class="h-80 md:h-60 relative overlay before:bg-black before:inset-0 before:opacity-60 bg-black"
         style="background-image: url({{ $user->profile->bannerImage()->getFullUrl() }}); background-size: cover; background-repeat: no-repeat;"
    >
        <div class="mb-1 mx-4 absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex flex-col md:mx-0 md:flex-row md:items-end">
                <div class="md:mr-3 z-10 md:-mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $user->profile->profile_photo_url }}" alt="{{ $user->name }}"/>
                </div>
                <div class="mb-2 sm:ml-3 space-y-1">
                    <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-3">
                        <x-library::heading.1 class="text-2xl sm:text-3xl" text-color="text-white-text-color">{{ $user->name  }}</x-library::heading.1>
                        <x-library::heading.2 class="font-normal" textSize="text-lg sm:text-xl sm:text-2xl" text-color="text-white-text-color">{{ '@' .  $user->handle }}</x-library::heading.2>
                    </div>
                    <div class="flex flex-wrap space-x-2 items-center text-primary text-sm">
                        @if (\Platform::isUsingUserSubscriptions() && \Platform::isSubscriptionShownInProfileHeader())
                            <span>{{ ($user->chargentSubscription()->latest()->first()?->isActive) ? $user->chargentSubscription()->latest()->first()->type->name : 'Not Active' }}</span>
                            <x-dot class="hidden sm:block" />
                        @endif
                        @if ($user->profile->country)
                            <span>{{ $user->profile->displayCountry() }}</span>
                            <x-dot class="hidden sm:block" />
                        @endif
                        <p class="text-primary whitespace-nowrap">Joined about {{ $user->profile->created_at->diffForHumans() }}</p>
                        <x-dot class="hidden sm:block" />
                        @if($user->online_status)
                            <x-tag name="Online" class="py-0"/>
                        @else
                            <x-tag name="Offline" class="py-0"/>
                        @endif
                    </div>
                </div>
            </div>
            {{-- No program to calculate reviewScore yet
                <div class="flex items-center text-white-text-color text-3xl font-semibold">
                <x-heroicon-s-star class="w-6 h-6" />
                {{ $user->reviewScore ?? '3758' }}
            </div> --}}
        </div>
    </div>
    <x-profiles.overview-navigation class="bg-primary shadow" :user="$user"/>
</div>
