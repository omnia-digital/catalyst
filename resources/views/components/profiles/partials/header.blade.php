<div>
    <div class="h-60 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat relative overlay before:bg-secondary before:inset-0 before:opacity-60">
        <div class="mb-1 mx-[15px] absolute bottom-0 left-0 right-0 flex justify-between items-end">
            <div class="flex items-end">
                <div class="mr-3 z-10 -mb-12">
                    <img class="h-24 w-24 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                </div>
                <div>
                    <h1 class="text-3xl text-primary">{{ $user->name  }}</h1>
                    <p class="text-sm text-primary">{{ '@' .  $user->handle }}</p>
                </div>
            </div>
            {{-- No program to calculate reviewScore yet
                <div class="flex items-center text-primary text-3xl font-semibold">
                <x-heroicon-s-star class="w-6 h-6" />
                {{ $user->reviewScore ?? '3758' }}
            </div> --}}
        </div>
    </div>
    <x-profiles.overview-navigation class="bg-neutral" :user="$user" />
</div>