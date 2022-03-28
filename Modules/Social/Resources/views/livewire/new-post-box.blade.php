<div x-data="{ reactionMenuOpen: false, attachmentDrawer: false, postSent: @entangle('postSent') }" class="flex relative items-start w-full bg-primary px-4 py-6 shadow sm:p-6 sm:rounded-lg">
    <div wire:loading.flex wire:target="savePost" class="absolute z-10 inset-0 justify-center items-center bg-primary opacity-50">
        <x-loading-icon class="h-12 w-12 text-black" />
    </div>
    <div
        x-init="@this.on('postAdded', post => { setTimeout(() => { postSent = false }, 1500) })"
        x-show="postSent"
        class="absolute z-10 inset-0 flex justify-center items-center bg-secondary opacity-75"
    >
        <x-heroicon-o-badge-check class="h-24 w-24 text-green-600" />
    </div>
    <div class="flex-shrink-0">
        <img class="inline-block h-10 w-10 rounded-full" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" />
    </div>
    <div></div>
    <div class="min-w-0 flex-1">
        <form action="#" class="relative" wire:submit.prevent="savePost">

            <div class="flex justify-between">
                <div class="flex-1 px-2 rounded-lg overflow-hidden">
                    <label for="body" class="sr-only">What's going on?</label>
                    <input
                        type="text"  name="body" id="body"
                        class="block w-full py-3 border-0 resize-none focus:ring-0 sm:text-sm"
                        placeholder="What's going on?"
                        wire:model.defer="body"
                    >
                    @error('body') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
                    <!-- Spacer element to match the height of the toolbar -->
                    <div class="py-2" aria-hidden="true">
                        <!-- Matches height of button in toolbar (1px border + 36px content height) -->
                        <div class="py-px">
                            <div class="h-9"></div>
                        </div>
                    </div>
                </div>
                {{-- <x-jet-dropdown :content="$postTypes" :trigger="'trigger'" /> --}}
            </div>

            <div class="bottom-0 border-t border-gray-100 inset-x-0 pl-3 pr-2 pt-2 flex flex-wrap justify-between">
                <div class="flex items-center space-x-5">
                    <div class="flex items-center">
                        <button
                            type="button"
                            class="-m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-light-text-color hover:text-base-text-color"
                            x-on:click="attachmentDrawer = !attachmentDrawer"
                        >
                            <x-heroicon-o-paper-clip class="h-5 w-5" aria-hidden="true" />
                            <span class="sr-only">Attach a file</span>
                        </button>
                    </div>
                    {{-- <div class="flex items-center">
                        <div>
                            <span class="sr-only">
                                Your mood
                            </span>
                            <div class="relative">
                                <button
                                    @click="reactionMenuOpen = true"
                                    type="button"
                                    class="relative -m-2.5 w-10 h-10 rounded-full flex items-center justify-center text-light-text-color hover:text-base-text-color"
                                >
                                    <span class="flex items-center justify-center">
                                        @if (is_null($selected))
                                            <x-heroicon-o-emoji-happy class="flex-shrink-0 h-5 w-5" aria-hidden="true"  />
                                            <span class="sr-only">
                                                Add your mood
                                                </span>
                                        @endif
                                        @if (!is_null($selected))
                                            <div class="{{ $selected['bgColor'] . ' w-8 h-8 rounded-full flex items-center justify-center' }}">
                                                <x-dynamic-component :component="$selected['icon']" class="flex-shrink-0 h-5 w-5 {{ $selected['iconColor'] }}" aria-hidden="true"  />
                                            </div>
                                            <span class="sr-only">{{ $selected['name'] }}</span>
                                        @endif
                                    </span>
                                </button>

                                <div
                                    x-show="reactionMenuOpen" @click.away="reactionMenuOpen = false"
                                    x-transition:enter.duration.100ms
                                    x-transition:enter.opacity.0
                                    x-transition:enter.scale.95
                                    x-transition:leave.duration.75ms
                                    x-transition:leave.opacity.100
                                    x-transition:leave.scale.100
                                >
                                    <ul class="absolute z-10 mt-1 -ml-6 w-60 bg-primary shadow rounded-lg py-3 text-base-text-color ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm">
                                        @foreach ($moods as $mood)
                                            <li class="bg-primary cursor-default select-none relative py-2 px-3">
                                                <div class="flex items-center">
                                                    <div class="{{ $mood['bgColor'] . ' w-8 h-8 rounded-full flex items-center justify-center' }}">
                                                        <x-dynamic-component :component="$mood['icon']" class="{{ $mood['iconColor'] . ' flex-shrink-0 h-5 w-5' }}" aria-hidden="true"  />
                                                    </div>
                                                    <span class="ml-3 block font-medium truncate">{{ $mood['name'] }}</span>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="flex-shrink-0">
                    <button
                        wire:loading.attr="disabled"
                        type="submit" class="w-full block text-center px-4 py-2 border border-neutral shadow-sm text-sm font-medium rounded-md text-neutral bg-secondary hover:bg-neutral-light"
                    >
                        Post
                    </button>
                </div>
                <div x-cloak x-show="attachmentDrawer" class="basis-full h-2"></div>
                <div x-cloak x-show="attachmentDrawer" class="w-full">
                    <livewire:social::partials.attachment-drawer />
                </div>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>

</script>
@endpush
