<nav class="bg-gray-300 flex relative">
    <div class="-mt-20 absolute bottom-0 left-8 flex">
        <div class="mr-2">
            <img class="h-24 w-24 rounded-full" src="{{ $project->owner?->profile_photo_url }}" alt="{{ $project->owner->name }}" />
        </div>
        <div class="-mt-4">
            <h1 class="text-3xl">{{ $project->name  }}</h1>
            <p class="text-sm">{{ '@' .  $project->owner->handle }}</p>
        </div>
    </div>
    <div class="flex justify-between items-center w-full ml-32 relative z-10">
        <div class="flex">
            @foreach ($nav as $key => $item)
                <a href="#" class="py-4 mx-4 border-b-2 border-b-transparent {{ $pageView === $key ? 'border-b-secondary' : '' }} hover:border-b-secondary">{{ $item }}</a>
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
            <a href="#" class="py-4 mx-4 whitespace-nowrap">Edit Project</a>
            <livewire:social::partials.follow-button :model="$project->owner" class="py-4 mx-4"/>
            <div class="inline-flex items-center text-md">
                <button class="p-2 mx-2 inline-flex items-center text-sm rounded-full bg-primary">Add</button>
            </div>
            <div class="inline-flex items-center text-md">
                <button class="p-2 mx-2 inline-flex items-center text-sm rounded-full bg-primary"><x-heroicon-s-plus class="h-4 w-4" /></button>
            </div>
        </div>
    </div>
</nav>