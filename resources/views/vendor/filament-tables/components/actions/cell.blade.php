@php use function Filament\Support\prepare_inherited_attributes; @endphp
<x-filament-tables::cell
        :attributes="prepare_inherited_attributes($attributes)"
>
    <div class="whitespace-nowrap px-3 py-4">
        {{ $slot }}
    </div>
</x-filament-tables::cell>
