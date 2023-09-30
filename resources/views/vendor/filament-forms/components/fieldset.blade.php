@php use function Filament\Support\prepare_inherited_attributes; @endphp
<x-filament::fieldset
        :label="$getLabel()"
        :label-hidden="$isLabelHidden()"
        :attributes="
        prepare_inherited_attributes($attributes)
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getExtraAttributes(), escape: false)
    "
>
    {{ $getChildComponentContainer() }}
</x-filament::fieldset>
