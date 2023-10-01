<div>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="-ml-4 mb-4 flex justify-between items-center flex-wrap sm:flex-nowrap">
            <div class="ml-4 mt-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $player->name }}
                </h3>
            </div>
            <div class="ml-4 mt-4 flex-shrink-0">
                <button x-data x-on:click="$dispatch('show-slide-over')" type="button"
                        class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Edit Player
                </button>
            </div>
        </div>

        @if ($currentEpisode)
            <div class="relative w-full mx-auto mb-8">
                <x-jwplayer :episode="$currentEpisode->toPlayer($player)"/>
            </div>
        @endif

        <ul role="list"
            class="grid grid-cols-{{ $player->layoutSetting('columns') }} gap-x-4 gap-y-8 sm:gap-x-6 xl:gap-x-8">
            @foreach ($episodes as $episode)
                @if ($episode->id !== $currentEpisode->id)
                    <x-episode.grid-item
                            wire:key="episode-{{ $episode->id }}"
                            wire:click="selectEpisode({{ $episode->id }})"
                            :episode="$episode"
                    />
                @endif
            @endforeach
        </ul>

        <div class="mt-6">
            {{ $episodes->onEachSide(1)->links() }}
        </div>
    </div>

    <x-slide-over>
        <x-slot name="title">Edit Player: {{ $player->name }}</x-slot>
        <div class="flex-shrink-0 py-2 flex justify-end">
            <x-danger-button wire:click="$toggle('deletePlayerModalOpen')" wire:loading.attr="disabled">
                {{ __('Delete Player') }}
            </x-danger-button>

            <x-button class="ml-2" wire:click="updatePlayer" wire:loading.attr="disabled">
                {{ __('Update Player') }}
            </x-button>
        </div>
        <div class="space-y-6 pt-4 pb-5">
            <div>
                <x-input.label value="Name" required/>
                <x-input.text wire:model="name" id="name"/>
                <x-input.error for="name"/>
            </div>
            <div>
                <x-input.label value="Columns"/>
                <x-input.text type="number" wire:model="layout.columns" id="columns"/>
                <x-input.error for="layout.columns"/>
            </div>
            <div>
                <x-input.label value="Videos Per Page"/>
                <x-input.text type="number" wire:model="layout.video_per_page" id="video-per-page"/>
                <x-input.error for="layout.video_per_page"/>
            </div>
            <div>
                <x-input.label value="Background Color"/>
                <x-input.text type="color" wire:model="layout.background_color" id="background-color"/>
                <x-input.error for="layout.background_color"/>
                <x-input.help
                        value="You won't see the background changes in the preview, it only applies on your website."/>
            </div>
            <div>
                <x-input.label value="Not Live Image"/>
                <x-input.filepond id="not-live-image" wire:model="notLiveImage"
                                  :defaultImage="$currentNotLiveImage"/>
                <x-input-error for="notLiveImage" class="mt-2"/>
            </div>
            <div>
                <x-input.label value="Before Live Image"/>
                <x-input.filepond id="before-live-image" wire:model="beforeLiveImage"
                                  :defaultImage="$currentBeforeLiveImage"/>
                <x-input-error for="beforeLiveImage" class="mt-2"/>
            </div>
        </div>
        <div class="flex-shrink-0 py-2 flex justify-end">
            <x-danger-button wire:click="$toggle('deletePlayerModalOpen')" wire:loading.attr="disabled">
                {{ __('Delete Player') }}
            </x-danger-button>

            <x-button class="ml-2" wire:click="updatePlayer" wire:loading.attr="disabled">
                {{ __('Update Player') }}
            </x-button>
        </div>
    </x-slide-over>

    <x-confirmation-modal wire:model.live="deletePlayerModalOpen">
        <x-slot name="title">Delete Player: {{ $player->name }}</x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this player?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('deletePlayerModalOpen')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="deletePlayer" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
