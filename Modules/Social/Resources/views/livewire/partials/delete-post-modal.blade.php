<x-library::modal id="delete-post-modal" maxWidth="4xl" hideCancelButton>
    <x-slot name="title">Delete</x-slot>
    <x-slot name="content">
        {{ 'Are you sure you want to delete this? It cannot be undone.' }}
    </x-slot>
    <x-slot name="actions">
        <x-library::button wire:click="deletePost()">Delete</x-library::button>
    </x-slot>
</x-library::modal>
