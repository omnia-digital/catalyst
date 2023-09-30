<div
        x-cloak
        {{
            $attributes
                ->merge([
                    'wire:key' => "{$this->getId()}.table.reorder.indicator",
                ], escape: false)
                ->class([
                    'fi-ta-reorder-indicator flex gap-x-3 bg-gray-50 px-3 py-1.5 sm:px-6',
                ])
        }}
>
    <x-filament::loading-indicator
            wire:loading.delay=""
            wire:target="reorderTable"
            class="h-5 w-5 text-gray-400"
    />

    <span
            class="text-sm font-medium leading-6 text-gray-700"
    >
        {{ __('filament-tables::table.reorder_indicator') }}
    </span>
</div>
