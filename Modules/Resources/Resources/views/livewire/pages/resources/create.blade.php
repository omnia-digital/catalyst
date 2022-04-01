<div>
    <x-library::modal id="add-resource-modal" maxWidth="5xl">
        <x-slot name="title">Add Resource</x-slot>
        <x-slot name="content">
            <livewire:social::post-editor :title :wire:key="uniqid()" submit-text="Add Resource"/>
        </x-slot>
    </x-library::modal>

    <livewire:media-manager/>
</div>
