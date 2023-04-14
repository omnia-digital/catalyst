<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('createChannelModalOpen')" title="Channel" icon="heroicon-o-plus"/>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Name</x-table.heading>
                                    <x-table.heading>Player</x-table.heading>
                                    <x-table.heading>Created At</x-table.heading>
                                    <x-table.heading>
                                        <span class="sr-only">Action</span>
                                    </x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($channels as $channel)
                                    <x-table.row :loop="$loop" wire:key="{{ $channel->id }}">
                                        <x-table.cell class="font-medium text-gray-900">
                                            {{ $channel->name }}
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            <a href="{{ route('players.show', $channel->player) }}" class="text-indigo-600 hover:text-indigo-900">
                                                {{ $channel->player->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            <x-timezone :for="$channel->created_at" diffForHumans/>
                                        </x-table.cell>
                                        <x-table.cell class="text-right font-medium flex-1 items-center space-x-2">
                                            <x-form.button-link :to="route('channels.show', $channel)" target="_blank" size="p-2" secondary>
                                                <x-heroicon-o-eye class="w-4 h-4"/>
                                            </x-form.button-link>
                                            <x-form.button-link :to="route('channels.update', $channel)" size="p-2" secondary>
                                                <x-heroicon-o-pencil class="w-4 h-4"/>
                                            </x-form.button-link>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">No channel matched the given criteria.</p>
                                            <x-form.button wire:click="$toggle('createChannelModalOpen')" secondary size="py-1 px-4">
                                                Create Channel
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

    <x-jet-dialog-modal wire:model="createChannelModalOpen">
        <x-slot name="title">Create Channel</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="name" placeholder="{{ __('Name') }}"/>
                <x-jet-input-error for="name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Player" required/>
                <x-input.select id="player" wire:model.defer="player" :options="$players"/>
                <x-jet-input-error for="player" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('createChannelModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="createChannel" wire:loading.attr="disabled">
                {{ __('Create Channel') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
