<div>
    <div class="h-60 relative overlay before:bg-black before:inset-0 before:opacity-60 bg-black"
        style="background-image: url({{ $team->bannerImage()->getFullUrl() }}); background-size: cover; background-repeat: no-repeat;"
    >
        <div class="mb-1 mx-4 absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex items-end">
                <div class="mr-3 z-10 -mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $team->profile_photo_url }}" alt="{{ $team->name }}" />
                </div>
                <div>
                    <h1 class="text-3xl text-primary">{{ $team->name  }}</h1>
                    <p class="text-sm text-primary">{{ '@' .  $team->handle }}</p>
                </div>
            </div>
            {{-- No program to calculate reviewScore yet
                <div class="flex items-center text-white-text-color text-3xl font-semibold">
                <x-heroicon-s-star class="w-6 h-6" />
                {{ $team->owner->reviewScore ?? '3758' }}
            </div> --}}

            <div class="mb-2">
            @if ($team->tags()->count() > 0)
                <div class="flex flex-wrap justify-start mt-1 space-x-2">
                    @foreach($team->tags as $tag)
                        <x-tag :name="$tag->name" bg-color="neutral-dark-75" text-color="primary" text-size="2xs" link=""/>
                    @endforeach
                </div>
            @endif
            </div>
        </div>
    </div>
    <x-teams.overview-navigation class="bg-gray-300" :team="$team" />
</div>
