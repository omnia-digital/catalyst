<div>
    @if ($state)
        <x-jet-dialog-modal wire:model="editModalOpen">
            <x-slot name="title">Edit Episode</x-slot>
            <x-slot name="content">
                <div>
                    <x-input.label value="Title" required/>
                    <x-input.text id="title" wire:model.defer="state.title" placeholder="{{ __('Title') }}"/>
                    <x-jet-input-error for="state.title" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Published"/>
                    <x-input.toggle id="is_published" wire:model.defer="state.is_published" class="bg-black"/>
                    <x-jet-input-error for="state.is_published" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Date Recorded" required/>
                    <x-input.date id="date-recorded" wire:model.defer="state.date_recorded" placeholder="{{ __('Date Recorded') }}"/>
                    <x-jet-input-error for="state.date_recorded" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Description"/>
                    <x-input.textarea id="description" wire:model.defer="state.description" placeholder="{{ __('Description') }}"/>
                    <x-jet-input-error for="state.description" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Thumbnail"/>
                    <x-input.filepond id="thumbnail" wire:model.defer="thumbnail"/>
                    <x-jet-input-error for="thumbnail" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Series"/>
                    <x-input.selects wire:model.defer="selectedSeries" id="series" :options="$series"/>
                    <x-jet-input-error for="selectedSeries" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Main Speaker"/>
                    <x-input.select wire:model.defer="state.main_speaker_id" id="main-speaker" :options="$speakers" enableDefaultOption :default="null"/>
                    <x-jet-input-error for="state.main_speaker_id" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Main Passage"/>
                    <x-input.text id="main_passage" wire:model.defer="state.main_passage" placeholder="{{ __('Main Passage') }}"/>
                    <x-jet-input-error for="state.main_passage" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Other Passages"/>
                    <x-input.textarea id="other_passages" wire:model.defer="state.other_passages" placeholder="{{ __('Other Passages') }}"/>
                    <x-jet-input-error for="state.other_passages" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Topics"/>
                    <x-input.text id="topics" wire:model.defer="topics" placeholder="{{ __('Topics') }}"/>
                    <x-jet-input-error for="topics" class="mt-2"/>
                    <x-input.help>Each topic will be seperated by a comma (,).</x-input.help>
                </div>
                <div class="mt-4">
                    <x-input.label value="Category"/>
                    <x-input.select id="category" wire:model.defer="state.category_id" placeholder="Please select a category" :options="$categories" enableDefaultOption/>
                    <x-jet-input-error for="state.category_id" class="mt-2"/>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-jet-secondary-button wire:click="hideEditModal" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-button class="ml-2" wire:click="updateEpisode" wire:loading.attr="disabled">
                    {{ __('Update Episode') }}
                </x-jet-button>
            </x-slot>
        </x-jet-dialog-modal>
    @endif
</div>
