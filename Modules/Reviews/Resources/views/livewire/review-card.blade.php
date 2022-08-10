<div x-data="{}" class="flex justify-start items-start bg-primary shadow rounded-lg border border-neutral-light p-4">
    <div class="mr-2">
        <img class="h-8 w-8 rounded-full" src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" />
    </div>
    <div class="flex-1 space-y-2">
        <p class="text-dark-text-color font-semibold text-sm">{{ $review->user->name }}</p>
        <p class="text-light-text-color text-xs">{{ $review->body }}</p>
    </div>
    @if (auth()->user()->is($review->user))
        <div>
            <button 
                x-on:click.prevent="$dispatch('review-modal-{{ $review->reviewable->id }}', { type: 'open' })" 
                class="text-light-text-color hover:text-base-text-color"
            >
                <x-heroicon-o-pencil class="w-4 h-4" />
                <span class="sr-only">{{ \Trans::get('Edit Review') }}</span>
            </button>
        </div>
    @endif
</div>