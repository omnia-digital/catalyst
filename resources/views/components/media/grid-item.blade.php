@props([
    'selected' => false,
    'media'
])

<li {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="{{ $selected ? 'ring-2 ring-offset-2 ring-primary-500' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-neutral-light focus-within:ring-primary-500' }} group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-neutral-light overflow-hidden cursor-pointer relative">
        <img
                src="{{ $media->getUrl() }}"
                alt="{{ $media->name }}"
                class="{{ $selected ? '' : 'group-hover:opacity-75' }} object-cover pointer-events-none"
        >
    </div>
    <p class="mt-2 block text-sm font-medium text-black line-clamp-2 pointer-events-none">{{ $media->name }}</p>
    <p class="flex justify-start items-center space-x-1 text-sm font-medium text-neutral-dark pointer-events-none">
        <span>{{ $media->human_readable_size }}</span>
    </p>
</li>
