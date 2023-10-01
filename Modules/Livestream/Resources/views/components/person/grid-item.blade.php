@props([
    'selected' => false,
    'person',
    'embed' => false
])

<li {{ $attributes->merge(['class' => 'relative']) }}>

    @if ($person->photo)
        <div class="{{ $selected ? 'ring-2 ring-offset-2 ring-blue-500' : 'focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-blue-500' }} group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 overflow-hidden cursor-pointer relative">
            <img src="{{ $person?->photo }}" alt="{{ $person->name }}"
                 class="{{ $selected ? '' : 'group-hover:opacity-75' }} object-cover pointer-events-none">
        </div>
    @endif
    <p class="mt-2 block text-sm font-medium text-gray-900 line-clamp-2 pointer-events-none">{{ $person->name }}</p>

    {{--    <p class="flex justify-start items-center space-x-1 text-sm font-medium text-gray-500 pointer-events-none">--}}
    {{--        <span class="flex items-center"><i class="items-center text-3xs fas fa-circle"></i></span>--}}
    {{--        <span>{{ $person->created_at->format('m/j/y') }}</span>--}}
    {{--    </p>--}}
</li>
