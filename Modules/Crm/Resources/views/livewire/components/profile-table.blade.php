<div>
    <x-library::button wire:click="create" class="mb-4">
        <x-library::icons.icon class="mr-2"/>
        {{ __('Create') }}
    </x-library::button>
</div>
<div>
    {{ $this->table }}
</div>
