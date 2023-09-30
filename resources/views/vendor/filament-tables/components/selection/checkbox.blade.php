@php use function Filament\Support\prepare_inherited_attributes; @endphp
@php use Filament\Tables\Table; @endphp
@props([
    'label' => null,
])

<label class="flex">
    <x-filament::input.checkbox
            :attributes="
            prepare_inherited_attributes($attributes)
                ->merge([
                    'wire:loading.attr' => 'disabled',
                    'wire:target' => implode(',', Table::LOADING_TARGETS),
                ], escape: false)
        "
    />

    @if (filled($label))
        <span class="sr-only">
            {{ $label }}
        </span>
    @endif
</label>
