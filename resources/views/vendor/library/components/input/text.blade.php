@props([
'type' => 'text',
'label',
'required' => false,
'placeholder' => null
])

@if (isset($label))
    <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-blue-600 focus-within:border-blue-600">
        <label for="{{ $attributes->only('id')->first() }}" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-sm font-medium text-gray-900">
            {{ $label }}

            @if ($required)
                <span class="text-red-600 text-sm">*</span>
            @endif
        </label>
        <input type="{{ $type }}" {{ $attributes->merge(['class' => 'block w-full border-0 pt-1 px-0 pb-0 text-gray-900 placeholder-gray-500 focus:ring-0 text-sm', 'placeholder' => $placeholder ?? $label]) }}>
    </div>
@else
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md', 'placeholder' => $placeholder ?? $label ?? null]) }}>
@endif
