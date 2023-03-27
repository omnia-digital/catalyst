<div>
    <div wire:loading.delay.flex class="hidden items-center justify-center">
        <x-heroicon-o-refresh class="w-8 h-8 animate-spin text-gray-400 mb-2" />
        <span class="sr-only">Loading...</span>
    </div>
    @if ($media)
        <div>
            <div class="space-y-6 flex flex-col">
                <div>
                    <div class="block w-full rounded-lg overflow-hidden">
                        {{ $media->img() }}
                    </div>
                </div>
                <div class="mt-4 flex items-start justify-between">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">{{ $media->name }}</h2>
                        <p class="text-sm font-medium text-gray-500">{{ $media->human_readable_size }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="font-medium text-gray-900">Details</h3>
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Attached to</dt>
                        <dd class="text-gray-900">
                            @isset ($media->model)
                                <span class="font-bold">{{ class_basename($media->model) }}</span>: {{ $this->getModelName($media->model) }}
                            @else
                                <div>(Unattached)</div>
                                <div><a href="#">Attach</a></div>
                            @endisset
                        </dd>
                    </div>
                    

                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Collection</dt>
                        <dd class="text-gray-900">{{ $media->collection_name }}</dd>
                    </div>
                    
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Uploaded by</dt>
                        <dd class="text-gray-900">{{ $media->model->user?->name }}</dd>
                    </div>
                    
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Uploaded at</dt>
                        <dd class="text-gray-900">{{ $media->created_at->format('m/d/y') }}</dd>
                    </div>
                    
                    <div class="py-3 flex justify-between text-sm font-medium">
                        <dt class="text-gray-500">Dimensions</dt>
                        <dd class="text-gray-900">{{ $this->getWidth($media) . ' x ' . $this->getHeight($media)  }}</dd>
                    </div>
                </div>

                <div class="mt-auto">
                    <h3 class="text-dark-text-color font-bold">Actions</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <x-library::button.link target="_blank" href="{{ $media->getFullUrl() }}" primary="true">View</x-library::button.link>
                        <x-library::button.secondary wire:click.prevent="$set('showDeleteMediaModal', true)">Delete</x-library::button.secondary>
                    </div>
                </div>
            </div>

        </div>
    @else
        <div wire:loading.remove class="p-16">
            <x-heroicon-s-information-circle class="w-8 h-8 text-gray-400 mx-auto mb-2"/>
            <h2 class="font-medium text-gray-400 text-center">Select a file to view its information.</h2>
        </div>
    @endif
    @once
        <!-- Delete Modal -->
        <form wire:submit.prevent="deleteMedia">
            <x-jet-dialog-modal wire:model.defer="showDeleteMediaModal">
                <x-slot name="title">Delete Media</x-slot>
                <x-slot name="content">
                    <div>Are you sure you? This action is irreversible.</div>
                </x-slot>
                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$set('showDeleteMediaModal', false)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
            
                    <x-jet-button class="ml-2" type="submit" wire:loading.attr="disabled">
                        {{ __('Delete') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>
        </form>
    @endonce
</div>
