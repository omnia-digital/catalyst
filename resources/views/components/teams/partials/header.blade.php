<div class="sticky top-0 z-40">
    <div class="h-40 relative overlay before:bg-black before:inset-0 before:opacity-60 bg-black shadow-md"
        style="background-image: url({{ $team->bannerImage()->getFullUrl() ?? config('teams.defaults.cover_photo') }}); background-size: cover; background-repeat: no-repeat;"
    >
        <div class="mb-1 mx-4 absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex items-end">
                <div class="mr-3 z-10 -mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $team->profile_photo_url }}" alt="{{ $team->name }}" />
                </div>
                <div>
                    <x-library::heading.1 textColor="text-secondary">{{ $team->name  }}</x-library::heading.1>
                    <p class="text-sm text-secondary">{{ '@' .  $team->handle }}</p>
                </div>
            </div>
            {{-- No program to calculate reviewScore yet
                <div class="flex items-center text-white-text-color text-3xl font-semibold">
                <x-heroicon-s-star class="w-6 h-6" />
                {{ $team->owner->reviewScore ?? '3758' }}
            </div> --}}

            <div class="mb-2">
            @if ($team->teamTypes->count() > 0)
                <div class="flex flex-wrap justify-start mt-1 space-x-2">
                    @foreach($team->teamTypes as $tag)
                        <x-tag :name="$tag->name" text-color="primary" text-size="2xs" link=""/>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>
    <x-teams.overview-navigation class="bg-secondary" :team="$team" />
</div>
