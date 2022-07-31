<div>
    <div class="h-60 relative overlay before:bg-black before:inset-0 before:opacity-60 bg-black"
         style="background-image: url({{ $user->profile->bannerImage()->getFullUrl() }}); background-size: cover; background-repeat: no-repeat;"
    >
        <div class="mb-1 mx-4 absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex items-end">
                <div class="mr-3 z-10 -mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $user->profile->profile_photo_url }}" alt="{{ $user->name }}"/>
                </div>
                <div class="mb-2 ml-3 space-y-1">
                    <div class="flex space-x-3 items-end">
                        <h1 class="text-3xl text-primary">{{ $user->name  }}</h1>
                        <h2 class="font-normal text-primary">{{ '@' .  $user->handle }}</h2>
                    </div>
                    <div class="flex space-x-2 items-baseline text-primary text-sm">
                        <div class="flex items-center space-x-1">
                            <x-heroicon-o-location-marker class="w-4 h-4"/>
                            <span>{{ $user->profile->country }}</span>
                        </div>
                        <x-dot/>
                        <p>Joined about {{ $user->profile->created_at->diffForHumans() }}</p>
                        <x-dot/>
                        @if($user->online_status)
                            <x-tag name="Online" class="py-0"/>
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
