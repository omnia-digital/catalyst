<nav {{ $attributes->merge(['class' => 'flex relative']) }}>
    <div class="-mt-20 absolute bottom-2 left-8 flex">
        <div class="mr-2">
            <img class="h-24 w-24 rounded-full" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
        </div>
        <div class="-mt-4">
            <h1 class="text-3xl text-white">{{ $user->name  }}</h1>
            <p class="text-sm text-white">{{ '@' .  $user->handle }}</p>
        </div>
    </div>
    <div class="flex justify-between items-center w-full ml-32 relative z-10">
        <div class="flex">
            @foreach ($nav as $key => $item)
                <a href="{{ route('social.profile.' . $key, $user->handle) }}" class="py-4 mx-4 border-b-2 border-b-transparent {{ $pageView === $key ? 'border-b-secondary' : '' }} hover:border-b-secondary">{{ $item }}</a>
            @endforeach
            <x-library::dropdown>
                <x-slot name="trigger">
                    <button type="button" class="py-4 mx-4 flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                    </button>
                </x-slot>
                <x-library::dropdown.item>
                    Some dropdown item
                </x-library::dropdown.item>
            </x-library::dropdown>
        </div>
    </div>
    <div class="flex">
        <a href="{{ route('social.profile.edit', $user->id) }}" class="py-4 mx-4 whitespace-nowrap">Edit Profile</a>
        <livewire:social::partials.follow-button :model="$user" class="py-4 mx-4"/>
        <div class="inline-flex items-center text-md">
            <button class="p-2 mx-2 inline-flex items-center text-sm rounded-full bg-primary"><x-heroicon-s-plus class="h-4 w-4" /></button>
        </div>
    </div>
</nav>