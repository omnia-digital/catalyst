<div class="space-y-4">
    <div class="flex justify-between items-center">
        <x-library::heading.3 class="text-base-text-color font-semibold">{{ \Trans::get('Reviews') }} <span class="text-gray-400">({{ $model->reviews()->count() }})</span></x-library::heading.3>
        @can('add-review', $model)
            <a href="#"
            wire:click.prevent="$emitTo('reviews::create-review-modal', 'openReviewModal')"
            class="text-dark-text-color hover:underline hover:text-secondary"
            >
                {{ \Trans::get('Add Review') }}
            </a>
        @endcan
    </div>
    @if ($latestReview)
        <livewire:reviews::review-card :review="$latestReview" />
    @endif
    @foreach ($reviews as $review)
        <livewire:reviews::review-card :review="$review" wire:key="review-{{ $review->id }}" />
    @endforeach
</div>
