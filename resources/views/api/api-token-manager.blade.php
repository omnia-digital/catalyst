<div>
    <!-- Generate API Token -->
    <x-form-section submit="createApiToken">
        <x-slot name="title">
            {{ Trans::get('Create API Token') }}
        </x-slot>

        <x-slot name="description">
            {{ Trans::get('API tokens allow third-party services to authenticate with our application on your behalf.') }}
        </x-slot>

        <x-slot name="form">
            <!-- Token Name -->
            <div class="col-span-6 sm:col-span-4">
                <x-label for="name" value="{{ Trans::get('Token Name') }}"/>
                <x-input id="name" type="text" class="mt-1 block w-full" wire:model.live="createApiTokenForm.name"
                         autofocus/>
                <x-input-error for="name" class="mt-2"/>
            </div>

            <!-- Token Permissions -->
            @if (Laravel\Jetstream\Jetstream::hasPermissions())
                <div class="col-span-6">
                    <x-label for="permissions" value="{{ Trans::get('Permissions') }}"/>

                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                            <label class="flex items-center">
                                <x-checkbox wire:model.live="createApiTokenForm.permissions" :value="$permission"/>
                                <span class="ml-2 text-sm text-base-text-color">{{ $permission }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        </x-slot>

        <x-slot name="actions">
            <x-action-message class="mr-3" on="created">
                {{ Trans::get('Created.') }}
            </x-action-message>

            <x-button>
                {{ Trans::get('Create') }}
            </x-button>
        </x-slot>
    </x-form-section>

    @if ($this->user->tokens->isNotEmpty())
        <x-section-border/>

        <!-- Manage API Tokens -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ Trans::get('Manage API Tokens') }}
                </x-slot>

                <x-slot name="description">
                    {{ Trans::get('You may delete any of your existing tokens if they are no longer needed.') }}
                </x-slot>

                <!-- API Token List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($this->user->tokens->sortBy('name') as $token)
                            <div class="flex items-center justify-between">
                                <div>
                                    {{ $token->name }}
                                </div>

                                <div class="flex items-center">
                                    @if ($token->last_used_at)
                                        <div class="text-sm text-light-text-color">
                                            {{ Trans::get('Last used') }} {{ $token->last_used_at->diffForHumans() }}
                                        </div>
                                    @endif

                                    @if (Laravel\Jetstream\Jetstream::hasPermissions())
                                        <button class="cursor-pointer ml-6 text-sm text-light-text-color underline"
                                                wire:click="manageApiTokenPermissions({{ $token->id }})">
                                            {{ Trans::get('Permissions') }}
                                        </button>
                                    @endif

                                    <button class="cursor-pointer ml-6 text-sm text-red-500"
                                            wire:click="confirmApiTokenDeletion({{ $token->id }})">
                                        {{ Trans::get('Delete') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- Token Value Modal -->
    <x-dialog-modal wire:model.live="displayingToken">
        <x-slot name="title">
            {{ Trans::get('API Token') }}
        </x-slot>

        <x-slot name="content">
            <div>
                {{ Trans::get('Please copy your new API token. For your security, it won\'t be shown again.') }}
            </div>

            <x-input x-ref="plaintextToken" type="text" readonly :value="$plainTextToken"
                     class="mt-4 bg-neutral px-4 py-2 rounded font-mono text-sm text-base-text-color w-full"
                     autofocus autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"
                     @showing-token-modal.window="setTimeout(() => $refs.plaintextToken.select(), 250)"
            />
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('displayingToken', false)" wire:loading.attr="disabled">
                {{ Trans::get('Close') }}
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>

    <!-- API Token Permissions Modal -->
    <x-dialog-modal wire:model.live="managingApiTokenPermissions">
        <x-slot name="title">
            {{ Trans::get('API Token Permissions') }}
        </x-slot>

        <x-slot name="content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach (Laravel\Jetstream\Jetstream::$permissions as $permission)
                    <label class="flex items-center">
                        <x-checkbox wire:model.live="updateApiTokenForm.permissions" :value="$permission"/>
                        <span class="ml-2 text-sm text-base-text-color">{{ $permission }}</span>
                    </label>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('managingApiTokenPermissions', false)" wire:loading.attr="disabled">
                {{ Trans::get('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="updateApiToken" wire:loading.attr="disabled">
                {{ Trans::get('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Delete Token Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingApiTokenDeletion">
        <x-slot name="title">
            {{ Trans::get('Delete API Token') }}
        </x-slot>

        <x-slot name="content">
            {{ Trans::get('Are you sure you would like to delete this API token?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingApiTokenDeletion')" wire:loading.attr="disabled">
                {{ Trans::get('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deleteApiToken" wire:loading.attr="disabled">
                {{ Trans::get('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
