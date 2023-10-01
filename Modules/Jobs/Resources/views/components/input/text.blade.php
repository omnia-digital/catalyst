@props(['disabled' => false])

<div class="mt-1 rounded-md shadow-sm">
    @if (isset($icon))
        <div class="relative flex items-stretch flex-grow focus-within:z-10">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                {{ $icon }}
            </div>
            @endif

            @php
                $class = 'form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 pl-10';
                $class = isset($icon) ? $class : str_replace('pl-10', '', $class);
            @endphp
            <input {!! $attributes->merge(['class' => $class]) !!} {{ $disabled ? 'disabled' : '' }}>
            @if (isset($icon))
        </div>
    @endif
</div>
