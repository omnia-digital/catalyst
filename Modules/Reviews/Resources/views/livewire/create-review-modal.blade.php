<x-library::modal id="review-modal-{{ $model->id }}" maxWidth="3xl" hideCancelButton>
    <x-slot name="title">Review: {{ $model->name }}</x-slot>

    <x-slot name="content">
        {{ $this->form }}
        <div class="flex justify-end items-center mt-8 space-x-3">
            @auth
                @if ($model->reviewedBy(auth()->user()))
                    <a href="#" class="text-danger-600 hover:underline focus:underline active:underline"
                       wire:click.prevent="removeReview">{{ Translate::get('Delete Review') }}</a>
                    <x-library::button
                            class="hover:bg-neutral-dark"
                            wire:click.prevent="createReview"
                    >{{ Translate::get('Update Review') }}</x-library::button>
                @else
                    <x-library::button
                            class="hover:bg-neutral-dark"
                            wire:click.prevent="createReview"
                    >{{ Translate::get('Create Review') }}</x-library::button>
                @endif
            @endauth
        </div>
    </x-slot>
</x-library::modal>
