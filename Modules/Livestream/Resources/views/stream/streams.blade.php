<div class="py-12">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <x-panel-header xdata="{
                            text: 'Copy Server URL',

                            copy() {
                                this.$clipboard('{{ config('omnia.server_url') }}');

                                this.text = 'Copied';
                                setTimeout(() => { this.text = 'Copy Server URL' }, 2000);
                            }
                        }" title="Streams" icon="heroicon-o-clipboard" prevent="copy" iconClass="w-5 h-5 mr-2"/>


            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <x-table.heading>Stream ID</x-table.heading>
                                    <x-table.heading>Stream Key</x-table.heading>
                                    <x-table.heading>Status</x-table.heading>
                                    <x-table.heading>
                                        <span class="sr-only">Action</span>
                                    </x-table.heading>
                                </tr>
                                </thead>
                                <tbody>

                                @forelse ($streams as $stream)
                                    <x-table.row :loop="$loop" wire:key="{{ $stream->id . time() }}">
                                        <x-table.cell class="font-medium text-gray-900">
                                            {{ $stream->stream_id }}
                                        </x-table.cell>
                                        <x-table.cell class="text-gray-500">
                                            {{ $stream->stream_key }}
                                        </x-table.cell>
                                        <x-table.cell>
                                            @if ($stream->isActive())
                                                <x-heroicon-o-check class="w-5 h-5 text-green-500"/>
                                            @else
                                                <x-library::icons.icon name="x-mark" class="w-5 h-5 text-red-500"/>
                                            @endif
                                        </x-table.cell>
                                        <x-table.cell class="text-right font-medium flex-1 items-center space-x-2">
                                            <x-form.button-link
                                                x-data="{
                                                    text: 'Copy Stream Key',

                                                    streamKey: '{{ $stream->stream_key }}',

                                                    copy() {
                                                        this.$clipboard(this.streamKey);

                                                        this.text = 'Copied';
                                                        setTimeout(() => { this.text = 'Copy Stream Key' }, 2000);
                                                    }
                                                }"
                                                x-on:click.prevent="copy" x-text="text">
                                            </x-form.button-link>

                                            <x-form.button-link wire:click="openResetStreamKeyModal('{{ $stream->stream_id }}')" secondary>
                                                Reset Stream Key
                                            </x-form.button-link>
                                        </x-table.cell>
                                    </x-table.row>
                                @empty
                                    <x-table.empty>
                                        <div class="text-center">
                                            <p class="text-center text-gray-600 text-base my-4">We could not find your stream key. Please contact our support team.</p>
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

    <x-jet-confirmation-modal wire:model="resetStreamKeyModelOpen">
        <x-slot name="title">Reset Stream Key</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to reset this Stream key?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('resetStreamKeyModelOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="resetStreamKey" wire:loading.attr="disabled">
                {{ __('Reset Stream Key') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>
</div>
