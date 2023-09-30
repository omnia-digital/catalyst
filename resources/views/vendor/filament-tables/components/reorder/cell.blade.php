@php use function Filament\Support\prepare_inherited_attributes; @endphp
<x-filament-tables::cell
        :attributes="
        prepare_inherited_attributes($attributes)
            ->class(['w-1'])
    "
>
    <div class="px-1 py-2">
        {{ $slot }}
    </div>
</x-filament-tables::cell>
