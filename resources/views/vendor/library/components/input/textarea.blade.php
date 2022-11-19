@props([
'rows' => 3
])

<div class="flex w-full rounded-md shadow-sm">
    <textarea
        {{ $attributes->merge(['class' => 'relative z-10 flex-1 min-w-0 block w-full border-gray-300 placeholder-gray-500 rounded-l rounded-r focus:ring-primary focus:border-primary text-sm']) }}
        rows="{{ $rows }}"></textarea>
</div>
