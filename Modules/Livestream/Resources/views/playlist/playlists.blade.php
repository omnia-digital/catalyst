<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header click="$toggle('createPlaylistModalOpen')" title="Playlists" icon="heroicon-o-plus"/>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Name</x-table.heading>
                                    <x-table.heading>Created At</x-table.heading>
                                    <x-table.heading>
                                        <span class="sr-only">Action</span>
                                    </x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($playlists as $playlist)
                                    <x-table.row :loop="$loop" wire:key="playlist-{{ $playlist->id }}">
                                        <x-table.cell class="font-medium text-gray-900">
                                            <a href="{{ route('playlists.update', $playlist) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $playlist->name }}
                                            </a>
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            <x-timezone :for="$playlist->created_at" diffForHumans/>
                                        </x-table.cell>
                                        <x-table.cell
                                            x-data="{
                                                text: 'Copy Embed Code',

                                                copy() {
                                                    this.$clipboard($refs['embed-code-{{ $playlist->id }}'].innerText.trim());

                                                    this.text = 'Copied';
                                                    setTimeout(() => { this.text = 'Copy Embed Code' }, 2000);
                                                }
                                            }"
                                            class="text-right font-medium"
                                        >
                                            <a x-on:click.prevent="copy" x-text="text" href="#" class="text-indigo-600 hover:text-indigo-900"></a>
                                            <pre style="display: none;">
                                                <code x-ref="embed-code-{{ $playlist->id }}">
                                                    {{ '<div id="omnia-playlist"></div>' . '<script src="' . url('js/playlist.js') . '" data-embed="' . route('playlists.embed', $playlist) . '"></script>' }}
                                                </code>
                                            </pre>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">No playlists matched the given criteria.</p>
                                            <x-form.button-link wire:click.prevent="$toggle('createPlaylistModalOpen')" secondary>
                                                Create Playlist
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

    <x-jet-dialog-modal wire:model="createPlaylistModalOpen">
        <x-slot name="title">Create Playlist</x-slot>
        <x-slot name="content">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text id="name" wire:model.defer="name" placeholder="{{ __('Name') }}"/>
                <x-jet-input-error for="name" class="mt-2"/>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('createPlaylistModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="createPlaylist" wire:loading.attr="disabled">
                {{ __('Create Playlist') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
