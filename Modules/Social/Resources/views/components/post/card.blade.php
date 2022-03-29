@props([
    'post'
])

<div {{ $attributes->merge(['class' => 'bg-white px-4 py-5 sm:px-6 border-t border-gray-200']) }}>
    <div class="flex space-x-3">
        <div class="flex-shrink-0">
            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="{{ $post->user->profile->name }}">
        </div>
        <div class="min-w-0 flex-1">
            <p class="text-sm font-medium text-gray-900">
                <a href="#" class="hover:underline">
                    {{ $post->user->profile->name }}
                </a>
            </p>
            <p class="text-sm text-gray-500">
                @if ($post->isParent())
                    <a href="{{ $post->getUrl() }}" class="hover:underline">
                        {{ $post->created_at->diffForHumans() }}
                    </a>
                @else
                    {{ $post->created_at->diffForHumans() }}
                @endif
            </p>
        </div>
        <div class="flex-shrink-0 self-center flex">
            <div class="relative z-30 inline-block text-left">
                <x-library::dropdown>
                    <x-slot name="trigger">
                        <button type="button" class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600" id="menu-0-button" aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open options</span>
                            <x-heroicon-s-dots-vertical class="h-5 w-5"/>
                        </button>
                    </x-slot>
                    <x-library::dropdown.item>Report</x-library::dropdown.item>
                </x-library::dropdown>
            </div>
        </div>
    </div>

    <div class="w-full pb-5 pt-2">
        {!! Purify::clean($post->body) !!}
    </div>

    @if ($post->image)
        <div class="block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden pt-2">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="object-cover">
        </div>
    @endif

    @if ($media = $post->media[0] ?? null)
        <div class="block w-full aspect-w-10 aspect-h-3 rounded-lg overflow-hidden pt-2">
            <img src="{{ $media->getUrl() }}" alt="{{ $post->title }}" class="object-cover">
        </div>
    @endif

    <div class="px-6">
        <livewire:social::partials.post-actions wire:key="post-actions-{{ $post->id }}" :post="$post"/>
    </div>
</div>
