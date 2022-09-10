@props([
'type' => 'text',
'label',
'required' => false,
'placeholder' => null,
'class' => ''
])

@if (isset($label))
    <div class="relative border border-neutral-light rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-neutral-dark focus-within:border-neutral-dark">
        <label for="{{ $attributes->only('id')->first() }}" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-neutral text-sm font-medium text-neutral-dark">
            {{ $label }}

            @if ($required)
                <span class="text-red-600 text-sm">*</span>
            @endif
        </label>
        <input type="{{ $type }}" {{ $attributes->merge(['class' => "block w-full border-0 pt-1 px-0 pb-0 text-neutral-dark bg-neutral placeholder-neutral focus:ring-0 text-s " . $class,
        'placeholder' =>
        $placeholder
         ?? $label]) }}>
    </div>
@else
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'focus:ring-neutral-dark focus:border-neutral-dark block w-full shadow-sm sm:text-sm border-neutral-light rounded-md ' . $class, 'placeholder' => $placeholder ?? null]) }}>
@endif
