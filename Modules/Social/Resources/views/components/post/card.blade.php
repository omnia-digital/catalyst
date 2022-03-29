@props([
    'post'
])

<article {{ $attributes->merge(['class' => 'flex justify-start bg-white pl-3 pr-5 pt-4 shadow-sm rounded-lg']) }}>
    <div class="mr-3 flex-shrink-0">
        <img class="h-10 w-10 rounded-full" src="{{ $post->user?->profile_photo_url }}" alt="{{ $post->user->profile->name }}"/>
    </div>
    <div class="flex-1">
        <div class="flex space-x-3">
            <div class="min-w-0 flex-1">
                <div class="min-w-0 flex justify-start">
                    <div class="font-bold text-dark-text-color mr-2">
                        <a href="{{ route('social.profile.show', $post->user->handle) }}" class="hover:underline">{{ $post->user->name }}</a>
                    </div>
                    <div class="text-base-text-color">
                        @if ($post->isParent())
                        <a href="{{ $post->getUrl() }}" class="hover:underline">
                            <time datetime="{{ $post->created_at }}">{{ $post->created_at->diffForHumans(short: true) }}</time>
                        </a>
                        @else
                            {{ $post->created_at->diffForHumans() }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex-shrink-0 self-center flex">
                <div class="relative z-30 inline-block text-left">
                    <x-library::dropdown>
                        <x-slot name="trigger">
                            <button type="button" class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open options</span>
                                <x-heroicon-s-dots-horizontal class="h-5 w-5"/>
                            </button>
                        </x-slot>
                        <x-library::dropdown.item>Report</x-library::dropdown.item>
                    </x-library::dropdown>
                </div>
            </div>
        </div>

        <div class="w-full">
            {!! Purify::clean($post->body) !!}
        </div>

        @if ($post->image)
            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
            </div>
        @endif

        @if ($media = $post->media[0] ?? null)
            <div class="mt-3 block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden">
                <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="object-cover">
            </div>
        @endif

        <div class="">
            <livewire:social::partials.post-actions wire:key="post-actions-{{ $post->id }}" :post="$post"/>
        </div>
    </div>
</article>
