<x-library::modal id="create-team">
    <x-slot name="title">Create Project</x-slot>

    <x-slot name="content">
        <div>
            <x-library::input.text wire:model.defer="name" label="Name" placeholder="Name" required/>
            <x-library::input.error for="name"/>
        </div>
        <div class="mt-6">
            <x-library::input.text wire:model.defer="location" label="Location" placeholder="Location" required/>
            <x-library::input.error for="location"/>
        </div>
        <div class="mt-6">
            <x-library::input.label value="Date" required/>
            <x-library::input.date wire:model.defer="date" placeholder="Pick a date"/>
            <x-library::input.error for="date"/>
        </div>
        <div class="mt-6">
            <x-library::input.label value="Summary" required/>
            <x-library::input.textarea wire:model.defer="summary" placeholder="Summary"/>
            <x-library::input.error for="summary"/>
        </div>
        <div class="mt-6">
            <x-library::input.label value="Description"/>
            <x-library::input.textarea wire:model.defer="description" placeholder="Description"/>
            <x-library::input.error for="description"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-library::button wire:click.prevent="create" wire:target="create">Create</x-library::button>
    </x-slot>
</x-library::modal>
