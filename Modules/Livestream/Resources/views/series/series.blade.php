<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('createSeriesModalOpen')" title="Series" icon="heroicon-o-plus"/>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Name</x-table.heading>
                                    <x-table.heading>Episodes</x-table.heading>
                                    <x-table.heading>Created At</x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($series as $seriesItem)
                                    <x-table.row :loop="$loop" wire:key="series-{{ $seriesItem->id }}">
                                        <x-table.cell class="font-medium text-gray-900">
                                            <a href="{{ route('series.update', $seriesItem) }}"
                                               class="text-blue-600 hover:text-blue-900">
                                                {{ $seriesItem->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            {{ $seriesItem->episodes_count }}
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            <x-timezone :for="$seriesItem->created_at" diffForHumans/>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">No series matched the
                                                given criteria.</p>
                                            <x-form.button-link wire:click.prevent="$toggle('createSeriesModalOpen')"
                                                                secondary>
                                                Create Series
                                            </x-form.button-link>
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

    <x-dialog-modal wire:model.live="createSeriesModalOpen">
        <x-slot name="title">Create Series</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="name" placeholder="{{ __('Name') }}"/>
                <x-input-error for="name" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('createSeriesModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="createSeries" wire:loading.attr="disabled">
                {{ __('Create Series') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>
</div>
