<div>
    <x-library::tiptap
            wire:model.defer="content"
            heightClass="min-h-[40px]"
            wordCountType="character"
            characterLimit="500"
            placeholder="What\\'s happening?"
    />

    <div class="flex justify-end my-2">
        <x-library::button wire:click="submit" wire:target="submit">
            Post
        </x-library::button>
    </div>

    @livewire('media-manager')
</div>
