<div>
    @if ($state)
        <x-dialog-modal wire:model.live="editModalOpen">
            <x-slot name="title">Edit Episode</x-slot>
            <x-slot name="content">
                <div>
                    <x-input.label value="Title" required/>
                    <x-input.text id="title" wire:model="state.title" placeholder="{{ __('Title') }}"/>
                    <x-input-error for="state.title" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Published"/>
                    <x-input.toggle id="is_published" wire:model="state.is_published" class="bg-black"/>
                    <x-input-error for="state.is_published" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Date Recorded" required/>
                    <x-input.date id="date-recorded" wire:model="state.date_recorded"
                                  placeholder="{{ __('Date Recorded') }}"/>
                    <x-input-error for="state.date_recorded" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Description"/>
                    <x-input.textarea id="description" wire:model="state.description"
                                      placeholder="{{ __('Description') }}"/>
                    <x-input-error for="state.description" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Thumbnail"/>
                    <x-input.filepond id="thumbnail" wire:model="thumbnail"/>
                    <x-input-error for="thumbnail" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Series"/>
                    <x-input.selects wire:model="selectedSeries" id="series" :options="$series"/>
                    <x-input-error for="selectedSeries" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Main Speaker"/>
                    <x-input.select wire:model="state.main_speaker_id" id="main-speaker" :options="$speakers"
                                    enableDefaultOption :default="null"/>
                    <x-input-error for="state.main_speaker_id" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Main Passage"/>
                    <x-input.text id="main_passage" wire:model="state.main_passage"
                                  placeholder="{{ __('Main Passage') }}"/>
                    <x-input-error for="state.main_passage" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Other Passages"/>
                    <x-input.textarea id="other_passages" wire:model="state.other_passages"
                                      placeholder="{{ __('Other Passages') }}"/>
                    <x-input-error for="state.other_passages" class="mt-2"/>
                </div>
                <div class="mt-4">
                    <x-input.label value="Topics"/>
                    <x-input.text id="topics" wire:model="topics" placeholder="{{ __('Topics') }}"/>
                    <x-input-error for="topics" class="mt-2"/>
                    <x-input.help>Each topic will be seperated by a comma (,).</x-input.help>
                </div>
                <div class="mt-4">
                    <x-input.label value="Category"/>
                    <x-input.select id="category" wire:model="state.category_id"
                                    placeholder="Please select a category" :options="$categories" enableDefaultOption/>
                    <x-input-error for="state.category_id" class="mt-2"/>
                </div>
            </x-slot>
            <x-slot name="footer">
                <x-secondary-button wire:click="hideEditModal" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-button class="ml-2" wire:click="updateEpisode" wire:loading.attr="disabled">
                    {{ __('Update Episode') }}
                </x-button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
