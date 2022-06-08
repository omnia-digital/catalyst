<x-library::modal id="create-team">
    <x-slot name="title">Create Project</x-slot>

    <x-slot name="content">
        <div>
            <x-library::input.text wire:model.defer="name" label="Name" placeholder="Name" required/>
            <x-library::input.error for="name"/>
        </div>
        <div class="mt-6">
            <x-library::input.label value="Start Date"/>
            <x-library::input.date wire:model.defer="startDate" placeholder="Project Launch Date"/>
            <x-library::input.error for="startDate"/>
        </div>
        <div class="mt-6">
            <x-library::input.label value="Summary"/>
            <x-library::input.textarea wire:model.defer="summary" placeholder="Summary"/>
            <x-library::input.error for="summary"/>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-library::button wire:click.prevent="create" wire:target="create">Create</x-library::button>
    </x-slot>
</x-library::modal>
