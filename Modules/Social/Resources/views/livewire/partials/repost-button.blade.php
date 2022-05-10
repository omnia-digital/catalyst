<div x-data x-on:click.stop="">
    <div class="inline-flex items-center text-md">
        <button wire:click.prevent.stop="showRepostModal" type="button" class="inline-flex space-x-2 text-light-text-color hover:text-base-text-color">
            <x-heroicon-o-refresh class="h-5 w-5" aria-hidden="true"/>
            <span class="font-medium text-dark-text-color">{{ $model->reposts ?? '' }}</span>
            <span class="sr-only">Repost</span>
        </button>
    </div>

    <x-library::modal id="repost-modal-{{ $model->id }}" maxWidth="3xl" hideCancelButton>
        <x-slot name="title">Repost</x-slot>

        <x-slot name="content">
            <livewire:social::post-editor wire:key="repost-editor-{{ $model->id }}" editorId="repost-editor-{{ $model->id }}"/>

            <div class="flex justify-end pr-2">
                <article class="max-w-[600px] w-full flex bg-white p-4 shadow-sm border border-gray-200 rounded-md">
                    <div class="mr-3 flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="{{ $model->user?->profile_photo_url }}" alt="{{ $model->user->profile->name }}"/>
                    </div>
                    <div class="flex-1">
                        <div class="flex space-x-3">
                            <div class="min-w-0 flex-1">
                                <div class="min-w-0 flex justify-start">
                                    <div class="font-bold text-dark-text-color mr-2">
                                        <a href="{{ route('social.profile.show', $model->user->handle) }}" class="hover:underline">{{ $model->user->name }}</a>
                                    </div>
                                    <div class="text-base-text-color">
                                        {{ $model->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-full">
                            {!! Purify::clean($model->body) !!}
                        </div>

                        @if ($model->image)
                            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                                <img src="{{ $model->image }}" alt="{{ $model->title }}" class="object-cover">
                            </div>
                        @endif

                        @if ($media = $model->media[0] ?? null)
                            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                                <img src="{{ $media->getUrl() }}" alt="{{ $model->title }}" class="object-cover">
                            </div>
                        @endif
                    </div>
                </article>
            </div>
        </x-slot>
    </x-library::modal>
</div>
