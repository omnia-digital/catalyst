@props(['disabled' => false])

<div class="flex items-center h-5">
    <input type="radio" {!! $attributes->merge(['class' => 'form-radio h-4 w-4 text-light-blue-600 transition duration-150 ease-in-out cursor-pointer"']) !!} {{ $disabled ? 'disabled' : '' }}>
</div>
