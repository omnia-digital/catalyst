@props([
'rows' => 3,
'disabled' => false
])

<div class="rounded-md shadow-sm">
    <textarea
        {{ $attributes->merge(['class' => 'form-textarea mt-1 block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5']) }}
        rows="{{ $rows }}"></textarea>
</div>
