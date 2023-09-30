<div
        {{
            $attributes
                ->merge($getExtraAttributes(), escape: false)
                ->class(['fi-ta-text-summary grid gap-y-1 px-3 py-4'])
        }}
>
    @if (filled($label = $getLabel()))
        <span class="text-sm font-medium text-gray-950">
            {{ $label }}
        </span>
    @endif

    <span class="text-sm text-gray-500">
        {{ $formatState($getState()) }}
    </span>
</div>
