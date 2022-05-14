<div x-data x-on:click.stop="">
    <div class="inline-flex items-center text-sm">
        <button wire:click.prevent.stop="showRepostModal" type="button" class="inline-flex space-x-2 text-light-text-color hover:text-base-text-color">
            <x-heroicon-o-refresh class="h-5 w-5" aria-hidden="true"/>
            <span class="font-medium text-dark-text-color">{{ $model->reposts ?? '' }}</span>
            <span class="sr-only">Repost</span>
        </button>
    </div>

    <x-library::modal id="repost-modal-{{ $model->id }}" maxWidth="3xl" hideCancelButton>
        <x-slot name="title">Repost</x-slot>

        <x-slot name="content">
            <livewire:social::post-editor wire:key="repost-editor-{{ $model->id }}" editorId="repost-editor-{{ $model->id }}"/>

{{--            <livewire:social::components.post-card-dynamic :post="$model"/>--}}

        </x-slot>
    </x-library::modal>
</div>
