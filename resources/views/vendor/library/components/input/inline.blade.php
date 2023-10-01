<div
        x-data="{
            id: '{{ $this->model()->getKey() }}',

            focusInput(event) {
                if (event.detail.id != this.id) {
                    return;
                }

                this.$nextTick(() => {
                    if (!this.$refs.input) {
                        return;
                    }

                    this.$refs.input.focus();
                });
            }
        }"
        x-on:edit-mode.window="focusInput($event)"
>
    @if (!$this->editMode)
        <div class="flex items-center space-x-2">
            <div>{{ $text }}</div>

            <a href="#" wire:click.prevent="setEditMode">
                <x-heroicon-s-pencil x-tooltip="Edit" class="w-5 h-5 text-blue-500"/>
            </a>
        </div>
    @else
        <div class="flex items-center space-x-2">
            <div>{{ $input }}</div>

            <a href="#" wire:click.prevent="submitInlineData('{{ $this->model()->getKey() }}')">
                <x-heroicon-s-check x-tooltip="Save" class="w-5 h-5 text-green-500"/>
            </a>

            <a href="#" wire:click.prevent="$set('editMode', false)">
                <x-heroicon-s-x x-tooltip="Cancel" class="w-5 h-5 text-red-500"/>
            </a>
        </div>
    @endif
</div>
