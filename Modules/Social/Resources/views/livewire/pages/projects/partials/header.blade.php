<div class="-ml-4">
    <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat relative overlay before:bg-black before:inset-0 before:opacity-60">
        <div class="mb-1 mx-[15px] absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex items-end">
                <div class="mr-3 z-10 -mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $team->profile_photo_url }}" alt="{{ $team->name }}" />
                </div>
                <div>
                    <h1 class="text-3xl text-white">{{ $team->name  }}</h1>
                    <p class="text-sm text-white">{{ '@' .  $team->owner->handle }}</p>
                </div>
            </div>
            {{-- No program to calculate reviewScore yet
                <div class="flex items-center text-white text-3xl font-semibold">
                <x-heroicon-s-star class="w-6 h-6" />
                {{ $team->owner->reviewScore ?? '3758' }}
            </div> --}}
        </div>
    </div>
    <x-teams.overview-navigation class="bg-gray-300" :team="$team" />
</div>