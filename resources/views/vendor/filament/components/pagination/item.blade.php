@props([
    'active' => false,
    'disabled' => false,
    'icon' => null,
    'iconAlias' => null,
    'label' => null,
    'separator' => false,
])

@php
    $hasIcon = filled($icon);
    $hasLabel = filled($label) || $separator;
    $isDisabled = $disabled || $separator;
@endphp

<li
        @class([
            'overflow-hidden border-x-[0.5px] border-gray-200 first:rounded-s-lg first:border-s-0 last:rounded-e-lg last:border-e-0',
            'focus-within:z-10 focus-within:ring-2 focus-within:ring-primary-600' => ! $isDisabled,
        ])
>
    <button
            {{
                $attributes
                    ->merge([
                        'disabled' => $isDisabled,
                        'type' => 'button',
                    ], escape: false)
                    ->class([
                        'fi-pagination-item relative overflow-hidden p-2 text-sm font-semibold outline-none transition duration-75',
                        'text-gray-400 hover:text-gray-500' => $hasIcon,
                        'text-gray-700' => $hasLabel && (! ($active || $isDisabled)),
                        'hover:bg-gray-50' => ! $isDisabled,
                        'bg-gray-50 text-primary-600' => $active,
                        'cursor-default' => $separator,
                    ])
            }}
    >
        @if ($hasIcon)
            <x-filament::icon
                    :alias="$iconAlias"
                    :icon="$icon"
                    @class([
                        'fi-pagination-item-icon h-5 w-5',
                    ])
            />
        @endif

        @if ($hasLabel)
            <span class="px-1.5">
                {{ $label ?? '...' }}
            </span>
        @endif
    </button>
</li>
