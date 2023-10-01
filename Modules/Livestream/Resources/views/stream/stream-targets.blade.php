<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('createStreamTargetModalOpen')" title="Stream Target"
                            icon="heroicon-o-plus"/>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Name</x-table.heading>
                                    <x-table.heading>URL</x-table.heading>
                                    <x-table.heading>Stream Key</x-table.heading>
                                    <x-table.heading>
                                        <span class="sr-only">Action</span>
                                    </x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($streamTargets as $streamTarget)
                                    <x-table.row :loop="$loop" wire:key="{{ $streamTarget->id . time() }}">
                                        <x-table.cell class="font-medium text-gray-900">
                                            {{ $streamTarget->name }}
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            <a href="{{ $streamTarget->url }}"
                                               class="text-indigo-600 hover:text-indigo-900">
                                                {{ $streamTarget->url }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            {{ $streamTarget->stream_key }}
                                        </x-table.cell>
                                        <x-table.cell class="text-right font-medium flex-1 items-center space-x-2">
                                            <x-form.button-link :to="route('stream-targets.update', $streamTarget)"
                                                                size="p-2" secondary>
                                                <x-heroicon-o-pencil class="w-4 h-4"/>
                                            </x-form.button-link>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">No stream targets
                                                matched the given criteria.</p>
                                            <x-form.button wire:click="$toggle('createStreamTargetModalOpen')" secondary
                                                           size="py-1 px-4">
                                                Create Stream Target
                                            </x-form.button>
                                        </div>
                                    </x-table.empty>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model.live="createStreamTargetModalOpen">
        <x-slot name="title">Create Stream Target</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="streamTarget.name" placeholder="{{ __('Facebook') }}"/>
                <x-input-error for="streamTarget.name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="URL" required/>
                <x-input.text id="url" wire:model="streamTarget.url" placeholder="{{ __('URL') }}"/>
                <x-input-error for="streamTarget.url" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Stream Key" required/>
                <x-input.text id="stream-key" wire:model="streamTarget.stream_key"
                              placeholder="{{ __('Stream Key') }}"/>
                <x-input-error for="streamTarget.stream_ke" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('createStreamTargetModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="createStreamTarget" wire:loading.attr="disabled">
                {{ __('Create Stream Target') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <x-upgrade-plan-modal/>
</div>
