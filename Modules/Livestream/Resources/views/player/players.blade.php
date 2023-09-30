<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('createPlayerModalOpen')" title=" Player" icon="heroicon-o-plus"/>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Name</x-table.heading>
                                    <x-table.heading>Not Live Image</x-table.heading>
                                    <x-table.heading>Before Live Image</x-table.heading>
                                    <x-table.heading>Created At</x-table.heading>
                                    <x-table.heading>
                                        <span class="sr-only">Action</span>
                                    </x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($players as $player)
                                    <x-table.row :loop="$loop" wire:key="{{ $player->id }}">
                                        <x-table.cell class="font-medium text-gray-900">
                                            <a href="{{ route('players.show', $player) }}"
                                               class="text-blue-600 hover:text-blue-900">
                                                {{ $player->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            @if ($player->notLiveImageUrl)
                                                <img class="h-10 w-10 rounded-full" src="{{ $player->notLiveImageUrl }}"
                                                     alt="Not Live Image">
                                            @else
                                                <p>No Image</p>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            @if ($player->beforeLiveImageUrl)
                                                <img class="h-10 w-10 rounded-full text-center justify-center"
                                                     src="{{ $player->beforeLiveImageUrl }}" alt="Before Live Image">
                                            @else
                                                <p>No Image</p>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            <x-timezone :for="$player->created_at" diffForHumans/>
                                        </x-table.cell>
                                        <x-table.cell
                                                x-data="{
                                                text: 'Copy Embed Code',

                                                copy() {
                                                    this.$clipboard($refs['embed-code-{{ $player->id }}'].innerText.trim());

                                                    this.text = 'Copied';
                                                    setTimeout(() => { this.text = 'Copy Embed Code' }, 2000);
                                                }
                                            }"
                                                class="text-right font-medium"
                                        >
                                            <a x-on:click.prevent="copy" x-text="text" href="#"
                                               class="text-indigo-600 hover:text-indigo-900"></a>
                                            <pre style="display: none;">
                                                <code x-ref="embed-code-{{ $player->id }}">
                                                    {{ '<div id="omnia-app-player"></div>' . '<script src="' . url('js/scripts.js') . '" data-embed="' . route('players.embed', $player) . '"></script>' }}
                                                </code>
                                            </pre>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">No player matched the
                                                given criteria.</p>
                                            <x-form.button wire:click="$toggle('createPlayerModalOpen')" secondary
                                                           size="py-1 px-4">
                                                Create Player
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

    <x-dialog-modal wire:model.live="createPlayerModalOpen">
        <x-slot name="title">Create Player</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model="name" placeholder="{{ __('Name') }}"/>
                <x-input-error for="name" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Not Live Image"/>
                <x-input.filepond id="not-live-image" wire:model="notLiveImage"/>
                <x-input-error for="notLiveImage" class="mt-2"/>
            </div>
            <div class="mt-4">
                <x-input.label value="Before Live Image"/>
                <x-input.filepond id="before-live-image" wire:model="beforeLiveImage"/>
                <x-input-error for="beforeLiveImage" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('createPlayerModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="createPlayer" wire:loading.attr="disabled">
                {{ __('Create Player') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    @once
        @push('scripts')
            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
        @endpush

        @push('styles')
            <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
            <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
                  rel="stylesheet">
        @endpush
    @endonce
</div>
