<div>
    <x-section-border/>

    <div class="mt-10 sm:mt-0">
        <x-form-section submit="updateCompany">
            <x-slot name="title">
                {{ __('Company About') }}
            </x-slot>

            <x-slot name="description">
                {{ __('The company\'s information.') }}
            </x-slot>

            <x-slot name="form">
                <!-- About -->
                <div class="col-span-6">
                    <x-label for="name" value="{{ __('About') }}"/>

                    <x-input.textarea
                            id="about"
                            class="mt-1 block w-full"
                            wire:model="state.about"
                            :disabled="! Gate::check('update', $company)"/>

                    <x-input-error for="about" class="mt-2"/>
                </div>
            </x-slot>

            @if (Gate::check('update', $company))
                <x-slot name="actions">
                    <x-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-action-message>

                    <x-button>
                        {{ __('Save') }}
                    </x-button>
                </x-slot>
            @endif
        </x-form-section>

    </div>

</div>
