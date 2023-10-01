<div class="space-y-4">
    <div class="flex justify-between items-center">
        <x-library::heading.3 class="text-base-text-color font-semibold">{{ Trans::get('Reviews') }} <span
                    class="text-gray-400">({{ $model->reviews()->count() }})</span></x-library::heading.3>
        @can('add-review', $model)
            <a href="#"
               wire:click.prevent="$dispatch('openReviewModal)->to('reviews::create-review-modal)"
               class="text-dark-text-color hover:underline hover:text-primary"
            >
                {{ Trans::get('Add Review') }}
            </a>
        @endcan
    </div>
    @if ($latestReview)
        <livewire:reviews::review-card :review="$latestReview"/>
    @endif
    @foreach ($reviews as $review)
        <livewire:reviews::review-card :review="$review" wire:key="review-{{ $review->id }}"/>
    @endforeach
</div>
