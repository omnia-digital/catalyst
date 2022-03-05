@props([
    'title',
    'description',
    'actions'
])

<div class="flex-1 flex items-center justify-between border border-gray-200 bg-white rounded-md truncate">
    <div class="flex-1 px-4 py-2 text-sm truncate">
        <a href="#" {{ $attributes->merge(['class' => 'text-gray-900 font-medium hover:text-gray-600']) }}>{{ $title }}</a>

        @if (isset($description))
            <p {{ $description->attributes->class(['text-gray-500']) }}>{{ $description }}</p>
        @endif
    </div>

    @if (isset($actions))
        <div class="flex-shrink-0 pr-2">
            {{ $actions }}
        </div>
    @endif
</div>
