<div x-data="{}" class="grid grid-cols-3 justify-start items-start bg-primary shadow rounded-lg border border-neutral-light p-4">
    <div class="col-span-1 flex">
        <div class="mr-2">
            <img class="h-8 w-8 rounded-full" src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}"/>
        </div>
        <div class="flex-1 space-y-1">
            <p class="text-dark-text-color font-semibold text-sm">{{ $review->user->name }}</p>
            <p class="text-2xs text-light-text-color">{{ $review->user->teams()->count() . Str::plural(\Trans::get(" team"), $review->user->teams()->count()) }}</p>
            <p class="text-2xs text-light-text-color">{{ $review->user->reviews()->count() . Str::plural(\Trans::get(" review"), $review->user->reviews()->count()) }}</p>
        </div>
    </div>
    <div class="col-span-2 space-y-2">
        <div class="flex items-start justify-between">
            <div class="flex items-start">
                @if ($review->recommend)
                    <div class="mr-2 bg-blue-600 p-1 rounded-full flex items-center justify-center">
                        <x-heroicon-s-thumb-up class="w-8 h-8 text-blue-400"/>
                    </div>
                    <div class="flex-1">
                        <p class="uppercase text-lg font-bold">Recommended</p>
                        <p class="text-neutral-dark text-2xs">Member for {{ $review->reviewable->users()->where('users.id', $review->user_id)->first()?->membership->created_at->longAbsoluteDiffForHumans($review->created_at) }} at review time</p>
                    </div>
                @endif
            </div>
            @auth
                @if (auth()->user()->is($review->user))
                    <div>
                        <button
                                wire:click.prevent="$emitTo('reviews::create-review-modal', 'openReviewModal')"
                                class="text-light-text-color hover:text-base-text-color"
                        >
                            <x-heroicon-o-pencil class="w-4 h-4"/>
                            <span class="sr-only">{{ \Trans::get('Edit Review') }}</span>
                        </button>
                    </div>
                @endif
            @endauth
        </div>
        <div>
            <p class="mt-2 text-light-text-color text-xs">{{ $review->body }}</p>
        </div>
        <div class="mt-4">
            <p class="text-light-text-color text-xs">{{ \Trans::get($review->likesCount() . ' ' . Str::plural('person', $review->likesCount()) . ' found this review helpful') }}</p>
            <div class="flex space-x-1 mt-3">
                <p class="text-light-text-color text-xs">Helpful</p>
                <livewire:social::partials.like-button
                        :model="$review"
                        :hideCount="true"
                        :withDislikes="true"
                        :btnStyles="'h-4 w-4'"
                />
            </div>
        </div>
    </div>
</div>
