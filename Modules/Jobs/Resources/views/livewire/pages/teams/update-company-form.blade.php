<div>
    <x-jet-section-border/>

    <div class="mt-10 sm:mt-0">
        <x-jet-form-section submit="updateCompany">
            <x-slot name="title">
                {{ __('Company About') }}
            </x-slot>

            <x-slot name="description">
                {{ __('The company\'s information.') }}
            </x-slot>

            <x-slot name="form">
                <!-- About -->
                <div class="col-span-6">
                    <x-jet-label for="name" value="{{ __('About') }}"/>

                    <x-input.textarea
                        id="about"
                        class="mt-1 block w-full"
                        wire:model.defer="state.about"
                        :disabled="! Gate::check('update', $company)"/>

                    <x-jet-input-error for="about" class="mt-2"/>
                </div>
            </x-slot>

            @if (Gate::check('update', $company))
                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    <x-jet-button>
                        {{ __('Save') }}
                    </x-jet-button>
                </x-slot>
            @endif
        </x-jet-form-section>

    </div>

</div>
