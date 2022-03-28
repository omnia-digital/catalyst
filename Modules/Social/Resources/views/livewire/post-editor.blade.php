<div>
    <x-library::tiptap
            wire:model.defer="content"
            heightClass="min-h-[80px]"
            wordCountType="character"
            characterLimit="500"
            :placeholder="$placeholderText"
    />

    <div class="flex justify-between">
        <div>
            <x-library::input.error for="content" class="mt-2"/>
        </div>

        <div class="flex justify-end my-2">
            <x-library::button wire:click="submit" wire:target="submit">
                Post
            </x-library::button>
        </div>
    </div>

    @livewire('media-manager')
</div>
