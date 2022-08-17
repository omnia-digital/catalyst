<div x-data="{}" class="grid grid-cols-3 justify-start items-start bg-primary shadow rounded-lg border border-neutral-light p-4">
    <div class="col-span-1">
        <div class="mr-2">
            <img class="h-8 w-8 rounded-full" src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" />
        </div>
        <div class="flex-1 space-y-2">
            <p class="text-dark-text-color font-semibold text-sm">{{ $review->user->name }}</p>
        </div>
    </div>
    <div class="col-span-2 space-y-2">
        <div class="flex items-start justify-between">
            <div class="flex items-start">
                <div class="mr-2 bg-blue-600 p-1 rounded-full flex items-center justify-center">
                    <x-heroicon-s-thumb-up class="w-8 h-8 text-blue-400" />
                </div>
                <div class="flex-1">
                    <p class="uppercase text-lg font-bold">Recommended</p>
                    <p class="text-neutral-dark text-2xs">Member for 6 days at review time</p>
                </div>
            </div>
            @if (auth()->user()->is($review->user))
                <div>
                    <button 
                        wire:click.prevent="$emitTo('reviews::create-review-modal', 'openReviewModal')" 
                        class="text-light-text-color hover:text-base-text-color"
                    >
                        <x-heroicon-o-pencil class="w-4 h-4" />
                        <span class="sr-only">{{ \Trans::get('Edit Review') }}</span>
                    </button>
                </div>
            @endif
        </div>
        <div>
            <p class="mt-2 text-light-text-color text-xs">{{ $review->body }}</p>
        </div>
        <div class="space-y-1">
            <p class="text-light-text-color text-xs">{{ \Trans::get('81 people found this review helpful') }}</p>
            <div class="flex space-x-1">
                <p class="text-light-text-color text-xs">Helpful</p>
                <x-heroicon-s-thumb-up class="w-4 h-4 text-neutral hover:text-netral-dark" />
                <x-heroicon-s-thumb-down class="w-4 h-4 text-neutral hover:text-netral-dark" />
            </div>
        </div>
    </div>
</div>