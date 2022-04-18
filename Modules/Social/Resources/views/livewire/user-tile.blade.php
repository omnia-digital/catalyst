<div class="bg-primary border border-neutral-light rounded w-full max-w-xs">
    <div class="relative">
        <div class="h-24 bg-[url('https://source.unsplash.com/random')] bg-cover bg-no-repeat"></div>
        <div class="absolute -bottom-12 left-5">
            <img class="h-20 w-20 rounded-full border-4 border-white bg-white" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
        </div>
    </div>
    <div class="space-y-2 p-4">
        <div class="flex justify-between">
            <div>
                <p class="text-dark-text-color font-semibold text-xs pt-10">{{ $user->name }}</p>
                <p class="text-light-text-color text-xs">{{ '@' . $user->handle }}</p>
            </div>
            <div>
                <livewire:social::partials.follow-button  :model="$user"/>
            </div>
        </div>
        
    </div>
</div>
